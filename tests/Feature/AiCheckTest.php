<?php

use App\Jobs\AiCheckAnalyzeJob;
use App\Models\AiCheckJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

it('validates that only doc and docx files are accepted', function () {
    $this->actingAs(\App\Models\User::factory()->create());

    // Invalid extension
    $response = $this->post(route('ai.check.submit'), [
        'document' => UploadedFile::fake()->create('test.txt', 10, 'text/plain'),
    ]);

    $response->assertSessionHasErrors('document');

    // Valid docx
    $response = $this->post(route('ai.check.submit'), [
        'document' => UploadedFile::fake()->create('test.docx', 10, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
    ]);

    $response->assertSessionDoesntHaveErrors('document');
});

it('creates async AiCheck job and dispatches queue job', function () {
    Queue::fake();

    $user = \App\Models\User::factory()->create();
    $this->actingAs($user);

    config()->set('services.aicheck.url', 'http://aicheck.test/api/v1/analyze');

    $response = $this->postJson(route('ai.check.submit'), [
        'document' => UploadedFile::fake()->create('test.docx', 10, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
    ]);

    $response->assertOk()
        ->assertJson(['success' => true])
        ->assertJsonStructure(['job_id']);

    $jobId = $response->json('job_id');
    $job = AiCheckJob::find($jobId);

    expect($job)->not()->toBeNull();
    expect($job->user_id)->toBe($user->id);
    expect($job->status)->toBe(AiCheckJob::STATUS_PENDING);

    Queue::assertPushed(AiCheckAnalyzeJob::class, function (AiCheckAnalyzeJob $dispatched) use ($jobId) {
        return $dispatched->jobId === $jobId;
    });
});

it('processes AiCheck job and exposes status and pdf download', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user);

    // Fake stored file
    $file = UploadedFile::fake()->create('test.docx', 10, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    $storedPath = $file->storeAs('ai-check/uploads', 'test.docx');

    $job = AiCheckJob::create([
        'user_id' => $user->id,
        'status' => AiCheckJob::STATUS_PENDING,
        'source_filename' => 'test.docx',
        'stored_path' => $storedPath,
    ]);

    Http::fake([
        '*' => Http::response([
            'risk_level' => 'LOW',
            'detected_language' => 'RU',
            'assessment' => [
                'overall_assessment' => 'Все хорошо',
                'risk_level' => 'LOW',
                'major_findings' => [],
                'quality_scores' => [],
                'common_error_patterns' => [],
                'action_plan' => [],
                'spot_check' => [],
            ],
            'pdfs' => [
                'ru' => base64_encode('PDF-RU'),
            ],
        ], 200),
    ]);

    config()->set('services.aicheck.url', 'http://aicheck.test/api/v1/analyze');
    config()->set('services.aicheck.api_key', null);

    // Выполняем джоб синхронно
    (new AiCheckAnalyzeJob($job->id))->handle();

    $job->refresh();
    expect($job->status)->toBe(AiCheckJob::STATUS_DONE);
    expect($job->result_json)->not()->toBeNull();
    expect($job->pdf_ru_path)->not()->toBeNull();

    // Статус
    $statusResponse = $this->getJson(route('ai.check.status', $job));
    $statusResponse->assertOk()
        ->assertJson([
            'status' => AiCheckJob::STATUS_DONE,
            'has_result' => true,
            'has_error' => false,
        ]);

    // Страница результата
    $pageResponse = $this->get(route('ai.check.result', $job));
    $pageResponse->assertOk();

    // Скачивание PDF
    $pdfResponse = $this->get(route('ai.check.result.pdf', [$job->id, 'ru']));
    $pdfResponse->assertOk();
});


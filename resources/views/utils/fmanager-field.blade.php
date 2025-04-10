<form id="mainForm">
    <label for="selectedFilesInput">Выбранные файлы:</label><br>
    <input type="text" id="selectedFilesInput" name="selectedFiles" placeholder="Пути к файлам появятся здесь" readonly>
    <br>
    <button type="button" onclick="openFileManager()">Выбрать файлы</button>
</form>

<script>
    function openFileManager() {
        window.open('{{ route('fmanager.index') }}', 'FileManagerWindow', 'width=800,height=600,resizable=yes,scrollbars=yes');
    }

    window.handleSelectedFiles = function(files) {
        console.log("Полученные файлы: ", files);
        document.getElementById('selectedFilesInput').value = files.join(', ');
    }
</script>

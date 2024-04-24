document.addEventListener('DOMContentLoaded' ,function () {

    let loadManagerTimer = setInterval(function () {

        if(QuantummanagerLists.length > 0) {
            clearInterval(loadManagerTimer);
        }

        let quantumcombineselectfileAll = document.querySelectorAll('.quantumcombineselectfile');

        for(let i=0;i<quantumcombineselectfileAll.length;i++) {
            let buttonChange = quantumcombineselectfileAll[i].querySelector('.preview-file .change-button');
            let preveiwFile = quantumcombineselectfileAll[i].querySelector('.preview-file .preview');
            let inputFile = quantumcombineselectfileAll[i].querySelector('.input-file');
            let fmIndex = parseInt(quantumcombineselectfileAll[i].querySelector('.quantummanager').getAttribute('data-index'));
            let paths = inputFile.value.split('/');
            let nameFile = paths.pop();
            let currPath = paths.join('/');
            let div = document.createElement('div');
            div.style.backgroundImage = 'url("/' + inputFile.value + '")';

            buttonChange.addEventListener('click', function (ev) {
                QuantummanagerLists[fmIndex].Qantumupload.selectFiles();
                ev.preventDefault();
            });

            QuantummanagerLists[fmIndex].data.path = QuantummanagerLists[fmIndex].Qantumupload.options.directory;
            QuantummanagerLists[fmIndex].data.scope = QuantummanagerLists[fmIndex].Qantumupload.options.scope;

            QuantummanagerLists[fmIndex].events.add(this, 'uploadComplete', function (fm, el) {

                let pathFile = QuantummanagerLists[fmIndex].data.path + '/' + QuantummanagerLists[fmIndex].Qantumupload.filesLists.pop();
                QuantumUtils.ajaxGet.get(QuantumUtils.getFullUrl("/administrator/index.php?option=com_quantummanager&task=quantumviewfiles.getParsePath&path=" + encodeURIComponent(pathFile)
                    + '&scope=' + QuantummanagerLists[fmIndex].data.scope + '&v='
                    + QuantumUtils.randomInteger(111111, 999999))).done(function (response) {
                    response = JSON.parse(response);

                    if(response.path !== undefined) {
                        preveiwFile.setAttribute('href', response.path);
                        inputFile.value = response.path;
                    }

                });

            });
        }

    }, 50);


});
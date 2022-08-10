/**
 * 
 */


$(document).ready(function () {
        PDFView.initialize();
		PDFJS.getDocument(pdfAsArray)

        var params = PDFView.parseQueryString(document.location.search.substring(1));

        //#if !(FIREFOX || MOZCENTRAL)
        //var file = params.file || DEFAULT_URL;
		var file = pdfAsArray;
        //#else
        //var file = window.location.toString()
        //#endif

        //#if !(FIREFOX || MOZCENTRAL)
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
            document.getElementById('openFile').setAttribute('hidden', 'true');
        } else {
            document.getElementById('fileInput').value = null;
        }
        //#else
        //document.getElementById('openFile').setAttribute('hidden', 'true');
        //#endif

        // Special debugging flags in the hash section of the URL.
        var hash = document.location.hash.substring(1);
        var hashParams = PDFView.parseQueryString(hash);

        if ('disableWorker' in hashParams)
            PDFJS.disableWorker = (hashParams['disableWorker'] === 'true');

        //#if !(FIREFOX || MOZCENTRAL)
        var locale = navigator.language;
        if ('locale' in hashParams)
            locale = hashParams['locale'];
        mozL10n.setLanguage(locale);
        //#endif
        if ('textLayer' in hashParams) {
            switch (hashParams['textLayer']) {
                case 'off':
                    PDFJS.disableTextLayer = true;
                    break;
                case 'visible':
                case 'shadow':
                case 'hover':
                    var viewer = document.getElementById('viewer');
                    viewer.classList.add('textLayer-' + hashParams['textLayer']);
                    break;
            }
        }

        //#if !(FIREFOX || MOZCENTRAL)
        if ('pdfBug' in hashParams) {
            //#else
            //if ('pdfBug' in hashParams && FirefoxCom.requestSync('pdfBugEnabled')) {
            //#endif
            PDFJS.pdfBug = true;
            var pdfBug = hashParams['pdfBug'];
            var enabled = pdfBug.split(',');
            PDFBug.enable(enabled);
            PDFBug.init();
        }

        if (!PDFView.supportsPrinting) {
            document.getElementById('print').classList.add('hidden');
        }

        if (!PDFView.supportsFullscreen) {
            document.getElementById('fullscreen').classList.add('hidden');
        }

        if (PDFView.supportsIntegratedFind) {
            document.querySelector('#viewFind').classList.add('hidden');
        }

        // Listen for warnings to trigger the fallback UI.  Errors should be caught
        // and call PDFView.error() so we don't need to listen for those.
        PDFJS.LogManager.addLogger({
            warn: function () {
                PDFView.fallback();
            }
        });

        var mainContainer = document.getElementById('mainContainer');
        var outerContainer = document.getElementById('outerContainer');
        mainContainer.addEventListener('transitionend', function (e) {
            if (e.target == mainContainer) {
                var event = document.createEvent('UIEvents');
                event.initUIEvent('resize', false, false, window, 0);
                window.dispatchEvent(event);
                outerContainer.classList.remove('sidebarMoving');
            }
        }, true);

        document.getElementById('sidebarToggle').addEventListener('click',
          function () {
              this.classList.toggle('toggled');
              outerContainer.classList.add('sidebarMoving');
              outerContainer.classList.toggle('sidebarOpen');
              PDFView.sidebarOpen = outerContainer.classList.contains('sidebarOpen');
              PDFView.renderHighestPriority();
          });

        document.getElementById('viewThumbnail').addEventListener('click',
          function () {
              PDFView.switchSidebarView('thumbs');
          });

        document.getElementById('viewOutline').addEventListener('click',
          function () {
              PDFView.switchSidebarView('outline');
          });

        document.getElementById('previous').addEventListener('click',
          function () {
              PDFView.page--;
          });

        document.getElementById('next').addEventListener('click',
          function () {
              PDFView.page++;
          });

        document.querySelector('.zoomIn').addEventListener('click',
          function () {
              PDFView.zoomIn();
          });

        document.querySelector('.zoomOut').addEventListener('click',
          function () {
              PDFView.zoomOut();
          });

        document.getElementById('fullscreen').addEventListener('click',
          function () {
              PDFView.fullscreen();
          });

        document.getElementById('openFile').addEventListener('click',
          function () {
              document.getElementById('fileInput').click();
          });

        document.getElementById('print').addEventListener('click',
          function () {
              window.print();
          });

        document.getElementById('download').addEventListener('click',
          function () {
              PDFView.download();
          });

        document.getElementById('pageNumber').addEventListener('change',
          function () {
              PDFView.page = this.value;
          });

        document.getElementById('scaleSelect').addEventListener('change',
          function () {
              PDFView.parseScale(this.value);
          });

        document.getElementById('first_page').addEventListener('click',
          function () {
              PDFView.page = 1;
          });

        document.getElementById('last_page').addEventListener('click',
          function () {
              PDFView.page = PDFView.pdfDocument.numPages;
          });

        document.getElementById('page_rotate_ccw').addEventListener('click',
          function () {
              PDFView.rotatePages(-90);
          });

        document.getElementById('page_rotate_cw').addEventListener('click',
          function () {
              PDFView.rotatePages(90);
          });

        //#if (FIREFOX || MOZCENTRAL)
        //if (FirefoxCom.requestSync('getLoadingType') == 'passive') {
        //  PDFView.setTitleUsingUrl(file);
        //  PDFView.initPassiveLoading();
        //  return;
        //}
        //#endif

        //#if !B2G

        PDFView.open(file, 0);
        //#endif
    });
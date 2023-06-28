<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<script>
    function loadPDF(containerId, base64) {
        var pdfData = atob(base64);
        var pdfjsLib = window['pdfjs-dist/build/pdf'];

        pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

        var loadingTask = pdfjsLib.getDocument({
            data: pdfData
        });
        loadingTask.promise.then(function(pdf) {
            var pageNumber = 1;
            pdf.getPage(pageNumber).then(function(page) {
                var scale = 1.5;
                var viewport = page.getViewport({
                    scale: scale
                });

                var canvas = document.getElementById(containerId);
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);
                renderTask.promise.then(function() {
                    console.log('Page rendered');
                });
            });
        }, function(reason) {
            console.error(reason);
        });

    }
</script>

<div class="col-xs-12">
    <?= utilsTemplateAlert('A definição de posições no documento está disponível apenas para assinaturas do tipo "Desenho", "Texto", "Plotagem" ou "Rúbrica"', 'info') ?>
</div>

<?php
foreach ($operation_files as $key => $file) {
    echo <<<HTML
        <div class="col-xs-12 mb-2 text-center">
            <canvas id="pdf-reader{$key}"></canvas>
        </div>
        <script>loadPDF('pdf-reader{$key}','{$file->base64}');</script>
    HTML;
}
?>

<div class="col-xs-12 text-sm-end">
    <button type="submit" name="step" value="2" class="btn btn-secondary">Continuar</button>
</div>
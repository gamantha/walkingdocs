<?php

use yii\web\View;

$this->registerJsFile(
    '@web/js/editablegrid.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/editablegrid_renderers.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/editablegrid_editors.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/editablegrid_validators.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/editablegrid_utils.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/editablegrid_charts.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerCssFile("@web/css/editablegrid.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    'media' => 'screen',
], 'css-print-theme');

$this->registerJs(
    "			window.onload = function() {
				editableGrid = new EditableGrid(\"DemoGridJSON\"); 
				editableGrid.tableLoaded = function() { this.renderGrid(\"tablecontent\", \"testgrid\"); };
				editableGrid.loadJSON(\"../../grid.json\");
			} ",
    View::POS_HEAD,
    'my-button-handler'
);

?>
<form action="" method="post">
<div id="tablecontent">dadada</div>
    <input type="submit">

</form>

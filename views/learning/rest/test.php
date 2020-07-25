<?php
/* @var $this yii\web\View */

use yii\web\View;



$this->registerCssFile("@web/treant-js/Treant.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()]
]);


$this->registerJsFile(
    '@web/treant-js/Treant.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/treant-js/vendor/raphael.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerCss("
//body { background: #f00; }
.Treant > .node.all { 
  color: orange;
  font-weight: bold;
}

.Treant > .node.not { 
  color: red;
  font-weight: bold;
}

.Treant > .node.only.one { 
  color: blue;
  font-weight: bold;
}


");

//echo json_encode($json_object);


$script2 = '

var simple_chart_config = {
	chart: {
		container: "#OrganiseChart-simple",
		rootOrientation: "WEST",
	},
	nodeStructure: {
			text: { name: "ALL" },
							connectors : {
				    style : {
				    stroke : "red"
				    }
				},
		children: [
			{
				text: { name: "ANY" },
				HTMLclass : "any",

				children: [
					{
						text: { name: "First Asthma Symptom" }
					},
				]
			},
			{
				text: { name: "ANY" },
				children: [
					{
						text: { name: "ANY" },
						children: [
							{
								text: { name: "Asthma History" }
							}
						]
					},
					{
						text: { name: "ANY" },
						children: [
							{
								text: { name: "Asthma Trigger" }
							}
						]
					}
				]
			},
			{
				text: { name: "ANY" },
				children: [
					{
						text: { name: "Prolonged Expiration" }
					},
					{
						text: { name: "Wheeze" }
					},
					{
						text: { name: "Decreased Breath Sounds" }
					},
				]
			}
		]
	}
};
var c= \'{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_and"},"children":[{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 1"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 2"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 3"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 4"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 5"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 6"}}]}]},{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 1"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 2"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 3"}}]}]},{"item":{"type":"equation_any","codes":["Adjunct asthma medicine"]},"text":{"name":"equation_not"}}]},{"text":{"name":"equation_and"},"children":[{"text":{"name":"equation_any"},"children":[{"text":{"name":"Severe disease sign"}}]},{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 1"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 2"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 3"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 4"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 5"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 6"}}]}]},{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 1"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 2"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 3"}}]}]},{"text":{"name":"equation_or"},"children":[{"text":{"name":"equation_any"},"children":[{"text":{"name":"Terbutaline"}}]},{"text":{"name":"equation_any"},"children":[{"text":{"name":"Magnesium"}}]}]}]}]}\';
var d = \''.json_encode($json_object).'\';
simple_chart_config.nodeStructure = JSON.parse(d); 
new Treant( simple_chart_config );
';


$this->registerJs(
    $script2,
    View::POS_READY
);
//echo json_encode($json_object);
?>

<div class="chart" id="OrganiseChart-simple">
</div>



<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<div id="tonality" style="height: 400px"></div>
<?php

            $radio = 5;
            $TV = 3;
            $print = 11;



?>

<script type="text/javascript">
 var radio_value = <?php echo "$radio"; ?>;
 var tv_value = <?php echo "$TV"; ?>;
 var print_value = <?php echo "$print"; ?>;
// Create the chart
radio_value
tv_value
Highcharts.chart('tonality', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
    title: {
        text: 'narrative'
    }, tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}',sliced: true,
      selected: true
      },
      showInLegend: false
    }
  },
  
    series: [{
        name: 'Tonality',
        colorByPoint: true,
        data: [
            ['Safaricom',154] , ['Google',58] , ['Uber',33] , ['Facebook',30] , ['Digital Literacy Programme',28] , ['Ministry of Information, Communication & Technology',21] , ['East African Cables Limited',20] , ['Twitter',15] , ['Huawei Technologies',15] , ['Kenya ICT Authority',15] , ['Microsoft',13] , ['Amazon',12] , ['Konza ICT City',11] , ['Telkom ',10] , ['Postal Corporation of Kenya',9] , ['Communications Authority of Kenya (CAK)',9] , ['FinTech',8] , ['Konza Technopolis Development Authority (KoTDA',8] , ['Branch International',5] , ['Craft Silicon',5] , ['Liquid Telecom Kenya',4] , ['BrighterMonday',4] , ['Jumia',3] , ['IBM East Africa',3] , ['Airtel Uganda',2] , ['Wananchi Group ',2] , ['Netflix',2] , ['BRCK',2] , ['MTN Uganda',2] , ['Truecaller',2] , ['Airbnb Inc',2] , ['Nokia Siemens Networks',2] , ['SEACOM',2] , ['Uganda Communications Commission',2] , ['NaiLab Accelerator Ltd',1] , ['Lenovo',1] , ['MTN Business Kenya ',1] , ['Olive Communication',1] , ['CarePay',1] , ['Intel Corporations',1] , ['OLX Inc',1] , ['Jamii Telecommunications Ltd',1] , ['Kilimall ',1] , ['Loon',1]

        ]
      
    }]
});
</script>
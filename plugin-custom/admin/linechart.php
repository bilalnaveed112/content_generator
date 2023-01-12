<?php include "db.php";   ?>

<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Day');
      data.addColumn('number', 'Guardians of the Galaxy');
      data.addColumn('number', 'The Avengers');
      data.addColumn('number', 'Transformers: Age of Extinction');

      data.addRows([
        <?php
        $query = "SELECT * FROM barchart";
        $res = mysqli_query($conn, $query);   
        ob_start();
        while($data=mysqli_fetch_array($res)){
          $year = $data['year'];
          $sale = $data['sale'];
          $expenses = $data['expenses'];
          $profit = $data['profit'];
          ?>
          [<?php echo $year; ?> ,  <?php echo $sale; ?> ,  <?php echo $expenses; ?> ,  <?php echo $profit; ?>  ],
          <?php 
        }
        echo ob_get_clean();
        ?>
        // [6,   8.8, 13.6,  7.7],
        // [7,   7.6, 12.3,  9.6],
        // [8,  12.3, 29.2, 10.6],
        // [9,  16.9, 42.9, 14.8],
        // [10, 12.8, 30.9, 11.6],
        // [11,  5.3,  7.9,  4.7],
        // [12,  6.6,  8.4,  5.2],
        // [13,  4.8,  6.3,  3.6],
        // [14,  4.2,  6.2,  3.4]
      ]);

      var options = {
        chart: {
          title: 'Box Office Earnings in First Two Weeks of Opening',
          subtitle: 'in millions of dollars (USD)'
        },
        width: 900,
        height: 500,
        // axes: {
        //   x: {
        //     0: {side: 'top'}
        //   }
        // }
      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>
</head>
<body>
  <div id="line_top_x"></div>
</body>
</html>

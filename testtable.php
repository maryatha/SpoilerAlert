<?php
require_once 'config.php';
?>
<html>
<body>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
 <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">
 <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
 
<table id="table"
  data-detail-view="true">
  <thead>
  <tr>
    <th data-field="id">ID</th>
    <th data-field="name">Item Name</th>
    <th data-field="price">Item Price</th>
  </tr>
  
  </thead>
</table>
 

<script type="text/javascript">
   
  var $table = $('#table')
  
  function buildTable($el, cells, rows) {
    var i; var j; var row
    var columns = []
    var data = []

     
    columns.push({
        field: 'name',
        title: 'name',
        sortable: true
    })
    columns.push({
        field: 'description' ,
        title: 'description',
        sortable: true
    })

    columns.push({
        field: 'minutes',
        title: 'minutes',
        sortable: true
    })
     
    columns.push({
        field: 'field' + 2,
        title: 'Save or Rate',
        sortable: true
    })
    
    let array = [], n_steps_array = [], steps_array = [], tag_array = [], nutrition_array = [], ingredients_array = [], n_ingredients_array = [];
     <?php
        $value = "beef";
        $sql = "select * from recipes where name like \"%{$value}%\" limit 5";
         
        $result = $sql_conn->query($sql);
       
        while($row = $result->fetch_row()) {
            $rowID = $row[0]; 
            $name = $row[1]; // first row
            $description = $row[2]; // first row
            $minutes = $row[3]; // first row
            $tags = $row[4];
            $nutrition = $row[5];
            $n_steps = $row[6];
            $steps = $row[7];
            $ingredients = $row[8];
            $n_ingredients = $row[9];
            
    ?>

     
    row = {};
    array.push(<?php echo json_encode($rowID); ?>);
    n_steps_array.push(<?php echo json_encode($n_steps);?>);
    steps_array.push(<?php echo json_encode($steps); ?>);  
    tag_array.push(<?php echo json_encode($tags); ?>);
    nutrition_array.push(<?php echo json_encode($nutrition); ?>);
    ingredients_array.push(<?php echo json_encode($ingredients); ?>);
    n_ingredients_array.push(<?php echo json_encode($n_ingredients); ?>);

    row['name'] = <?php echo json_encode($name); ?>;
    row['description'] = <?php echo json_encode($description); ?>;
    row['minutes'] = <?php echo json_encode($minutes); ?>;
    data.push(row);
    <?php }?>
    
     

    $el.bootstrapTable({
      columns: columns,
      data: data,
      detailView: cells > 1,
      onExpandRow: function (index, row, $detail) {
        /* eslint no-use-before-define: ["error", { "functions": false }]*/
        console.log(array[index]);
        console.log(n_steps_array[index]);
        console.log(steps_array[index]);
        let myel = $detail.html('<table></table>').find('table');
        var mycolumns = [];
        var mydata = [];
        var myrow;
        var indexID = index;
        mycolumns.push({
        field: 'Number of Steps',
        title: 'Number of Steps',
        sortable: true
        })

        mycolumns.push({
        field: 'Steps',
        title: 'Steps',
        sortable: true
        })

        myrow = {};
        myrow['Number of Steps'] = n_steps_array[index];
        myrow['Steps'] = steps_array[index];
        mydata.push(myrow);

        myel.bootstrapTable({
          columns: mycolumns,
          data: mydata,
          detailView: cells > 1,
          onExpandRow: function (index, row, $detail){
            let myel1 = $detail.html('<table></table>').find('table');
            var mycolumns1 = [];
            var mydata1 = [];
            var myrow1;
            mycolumns1.push({
            field: 'tags',
            title: 'tags',
            sortable: true
            })

            mycolumns1.push({
            field: 'nutrition',
            title: 'nutrition',
            sortable: true
            })

            mycolumns1.push({
            field: 'n_ingredients',
            title: 'n_ingredients',
            sortable: true
            })

            mycolumns1.push({
            field: 'ingredients',
            title: 'ingredients',
            sortable: true
            })
            myrow1 = {};
            myrow1['tags'] = tag_array[indexID];
            myrow1['nutrition'] = nutrition_array[indexID];
            myrow1['n_ingredients'] = n_ingredients_array[indexID];
            myrow1['ingredients'] = ingredients_array[indexID];
            mydata1.push(myrow1);
            myel1.bootstrapTable({
            columns: mycolumns1,
            data: mydata1,
            detailView: cells > 1,
             
            })
          }
      })
      
      }
    })
  }

  function expandTable($detail, cells) {
    
  }

  $(function() {
    buildTable($table, 8, 2)
  })
</script>
</body>
</html>

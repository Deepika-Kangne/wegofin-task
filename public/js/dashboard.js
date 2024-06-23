var jQueryNoConflict = $.noConflict(); 
jQueryNoConflict(document).ready(function() {
  var dataContainer = document.getElementById("tableContainer");
   var isDataVisible = false;

  jQueryNoConflict('#processData').on('click', function () {

    isDataVisible = !isDataVisible;

    if (isDataVisible) {
      dataContainer.style.display = "block";
      ////AJAX
      jQueryNoConflict.ajax({
              url:'/api/emi-details',
              type: 'GET',
              beforeSend: function(xhr, opts) {},
              success: function(result) {
               
                let tableHtml = '<table border="1"><tr>';
                let columns = result[0];
                  console.log(columns);
                  columns.forEach(column => {
                      tableHtml += `<th>${column}</th>`;
                  });
                  tableHtml += '</tr>';
                  console.log(result);
                  result['data'].forEach(row => {
                      tableHtml += '<tr>';
                      row.forEach(val => {
                          tableHtml += `<td>${val}</td>`;
                      });
                      tableHtml += '</tr>';
                  });
                  tableHtml += '</table>';
                  jQueryNoConflict('#tableContainer').html(tableHtml);
                //return result;
              },
              error: function ( xhr, status, error) {
              }

            });
      ////AJAX
    } else {
        dataContainer.style.display = "none";
    }
      console.log('jQuery is sssssssssss working!');



    });
  });
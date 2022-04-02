//my stuff
let dateconvert = [];
let temparray = [];

//store date in array
for(let q = 0; q < graphdate.length; q++) {
    temparray = graphdate[q].split("-")
    dateconvert.push(temparray);
}

//google shit
google.charts.load('current', { 'packages': ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var data = new google.visualization.DataTable();
    data.addColumn('date', 'Time of Day');
    data.addColumn('number', 'Price');

    //bug: if the price and date are the same it will display 1 value
    //my stuff month starts at 0
    for(let i = 0; i < graphprice.length; i++) {
        data.addRows([
            //year month day price
            [new Date(dateconvert[i][0], dateconvert[i][1]-1, dateconvert[i][2]), graphprice[i]] 
        ]);
        console.log(dateconvert[i][0]);
        console.log(dateconvert[i][1]);
        console.log(dateconvert[i][2]);
    }


    var options = {
        title: 'Rate the Day on a Scale of 1 to 10',
        width: 900,
        height: 500,
        hAxis: {
            format: 'M/d/yy',
            gridlines: { count: 15 }
        },
        vAxis: {
            gridlines: { color: 'none' },
            minValue: 0
        }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

    chart.draw(data, options);

    var button = document.getElementById('change');

    button.onclick = function () {

        // If the format option matches, change it to the new option,
        // if not, reset it to the original format.
        options.hAxis.format === 'M/d/yy' ?
            options.hAxis.format = 'MMM dd, yyyy' :
            options.hAxis.format = 'M/d/yy';

        chart.draw(data, options);
    };
}
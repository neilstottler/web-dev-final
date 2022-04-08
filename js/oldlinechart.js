//define vars
let timeint = null;

google.charts.load('current', {
    packages: ['corechart', 'line']
});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'X');
    data.addColumn('number', 'Spending');

    //add some fucking data
    for (let i = 0; i < graphdate.length; i++) {
        timeint = Date.parse(graphdate[i]),
            data.addRows([
                [timeint, graphprice[i]]
            ]);
    }

    var options = {
        hAxis: {
            title: 'Date'
        },
        vAxis: {
            title: 'Cost'
        },
        backgroundColor: '#f1f8e9'
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
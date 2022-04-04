google.charts.load("current", { packages: ["calendar"] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'date', id: 'Date' });
    dataTable.addColumn({ type: 'number', id: 'Won/Loss' });


    const dates_prices = new Map();

    //insert first value
    dates_prices.set(graphdate[0], graphprice[0]);

    //insert a key: value in a loop then check on the second pass if the key already exists, then update key if it does?
    for (let i = 1; i < graphprice.length; i++) {

            //date already exists!
            if (dates_prices.has(graphdate[i])) {

                //gets the current value stored for conflicting date
                let addme = dates_prices.get(graphdate[i]);
                let final = addme + graphprice[i];
                dates_prices.set(graphdate[i], final);
                
            } else {
                //insert data where there is no conflicts
                dates_prices.set(graphdate[i], graphprice[i]);

            }

        
    }

    //we insert the data into the chart here
    for(let i = 1; i < graphprice.length; i++) {
        dataTable.addRows([
            //year month day price
            [new Date(dateconvert[i][0], dateconvert[i][1] - 1, dateconvert[i][2]), dates_prices.get(graphdate[i])]
        ]);
    }


    var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

    //styling for google
    //https://developers.google.com/chart/interactive/docs/gallery/calendar#configuration-options
    var options = {
        title: "Spending Habits",
        forceIFrame: false,
        height: 450,
        colorAxis: {
            colors: ['#047e00', '#e10000'],
        },
        calendar: {
            cellColor: {
                stroke: 'white'
            },
            monthOutlineColor: {
                stroke: 'blue',
                strokeOpacity: 0.8,
                strokeWidth: 2
            },
            unusedMonthOutlineColor: {
                stroke: 'blue',
                strokeOpacity: 0.8,
                strokeWidth: 2
            },
            monthLabel: {
                color: 'black',
                bold: true,
                fontSize: 20,
            },
            cellSize: 16,
            underYearSpace: 2,
            underMonthSpace: 12
        },
        noDataPattern: {
            backgroundColor: '#CCCCCC',
            color: '#CCCCCC'
        },

    };



    chart.draw(dataTable, options);
}
//my stuff
let dateconvert = [];
let temparray = [];

//store date in array
for (let q = 0; q < graphdate.length; q++) {
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

    const dates_prices = new Map();

    //bug: if the price and date are the same it will display 1 value
    //my stuff month starts at 0
    /*
    I already sort of did above, use an object as a map where keys are dates and values are prices
    go through everything and put them in, but if a date entry already exists then add to the price instead of setting it
    split it in different parts instead of trying to do date adding + parsing + row creation in the same loop
    (also just fyi you can apparently use  data.addRow() to get rid of the extra array you're putting around the plot point)
    https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Map
    */

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
        data.addRows([
            //year month day price
            [new Date(dateconvert[i][0], dateconvert[i][1] - 1, dateconvert[i][2]), dates_prices.get(graphdate[i])]
        ]);
    }

    //debugging map stuff
    console.log(dates_prices);


    var options = {
        title: 'Spending Totals Per Day',
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
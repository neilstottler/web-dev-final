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

    //bug: if the price and date are the same it will display 1 value
    //my stuff month starts at 0
    /*
    for(let i = 0; i < graphprice.length; i++) {
        data.addRows([
            //year month day price
            [new Date(dateconvert[i][0], dateconvert[i][1]-1, dateconvert[i][2]), graphprice[i]] 
        ]);
    }*/
    console.log(graphdate);
    console.log(graphprice);
    for (let i = 0; i < graphprice.length; i++) {

        //jank
        //checks if i will be outside of array
        if(i != graphprice.length - 1) {
            
            try {
                var item1 = dateconvert[i].toString();
                var item2 = dateconvert[i + 1].toString();

                console.log("graph price: " + graphprice[i]);
                //checking for dupe dates and adding the price to be a total sum
                if (item1 === item2) {
                    //need to add prices and remove the old ones from the array then aff to calendar

                    console.log("total: " + Number(graphprice[i]) + Number(graphprice[i + 1]));



                } else {
                    data.addRows([
                        //year month day price
                        [new Date(dateconvert[i][0], dateconvert[i][1] - 1, dateconvert[i][2]), graphprice[i]]
                    ]);
                }
            } catch (err) {
                //console.log(err);
            }
        //the last i should be inserted
        } else {
            //
            data.addRows([
                //year month day price
                [new Date(dateconvert[i][0], dateconvert[i][1] - 1, dateconvert[i][2]), graphprice[i]]
            ]);
        }
    }


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
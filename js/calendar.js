google.charts.load("current", { packages: ["calendar"] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'date', id: 'Date' });
    dataTable.addColumn({ type: 'number', id: 'Won/Loss' });

    for (let i = 0; i < graphprice.length; i++) {
        /*
        dataTable.addRows([
            //year month day price
            [new Date(dateconvert[i][0], dateconvert[i][1] - 1, dateconvert[i][2]), graphprice[i]]
        ]);*/

        //checks if i will be outside of array
        if (i != graphprice.length - 1) {
            try {
                var item1 = dateconvert[i].toString();
                var item2 = dateconvert[i + 1].toString();
                //checking for dupe dates and adding the price to be a total sum
                if (item1 === item2) {
                    //console.log("DUPPP didn't add: " + dateconvert[i]);
                    //need to add prices and remove the old ones from the array then aff to calendar
                } else {
                    dataTable.addRows([
                        //year month day price
                        [new Date(dateconvert[i][0], dateconvert[i][1] - 1, dateconvert[i][2]), graphprice[i]]
                    ]);
                }
            } catch (err) {
                //console.log(err);
            }

        //the last i should be inserted
        } else {
            dataTable.addRows([
                //year month day price
                [new Date(dateconvert[i][0], dateconvert[i][1] - 1, dateconvert[i][2]), graphprice[i]]
            ]);
        }
    }

    /*
    dataTable.addRows([
        [new Date(2022, 9, 4), 10],
        [new Date(2022, 9, 5), 3]
    ]);
    */

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
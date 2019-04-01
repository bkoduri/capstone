var engineApp=new Vue({
  el:'#engineApp',
  data: {
    "pds" : [
      {
        "pd_id":1,
        "pd_name": "X15 Efficiency Series"
      },
      {
        "pd_id":2,
        "pd_name": "QSK95"
      }
    ],
  "chartLogs": [
    {
        "pd_id": "",
        "collected_time": "",
        "rpm": "",
        "coolant_temp": "",
        "soot_buildup": "",
        "average_consumption": ""
    }
],
"allLogs": [
  {
      "pd_id": "",
      "collected_time": "",
      "rpm": "",
      "coolant_temp": "",
      "soot_buildup": "",
      "average_consumption": ""
  }
],
  post:{ }
},
  computed: {
  },
  methods:  {
    pretty_date: function (d) {
      return moment(d).format('l');
    },
    gotoSeries(cid) {
      this.chartLogs=this.allLogs.filter(log => log.pd_id==cid);
      console.log('selected chart:');
      console.log(this.chartLogs);
        this.formatHours();
        console.log('After format:');
        console.log(this.chartLogs);
        this.buildEffortChart("rpm");
        this.buildEffortChart("coolant_temp");
        this.buildEffortChart("soot_buildup");
        this.buildEffortChart("average_consumption");
    },
    fetch_logs(){
      fetch("https://cors.io/?http://ec2-34-222-136-163.us-west-2.compute.amazonaws.com/api/pdSeries.php")
      // fetch("https://api.myjson.com/bins/13scrg")
      // .then(function(response) { return response.json })
      .then( response => response.json())
      .then(json => {
        this.allLogs = json;
        console.log('FETCHED JSONlogs:');
        console.log(this.allLogs);
      })
      .catch( function(err) {
        console.log('FETCH ERROR:');
        console.log(err);
      })
    },
    formatHours() {
      this.chartLogs.forEach(
        (entry, index, arr) => {
          entry.convertDate = Date.parse(entry.collected_time); // Convert to ms since Jan 1, 1970 UTC
          entry.pd_id = Number(entry.pd_id);
          // entry.runningTotalHours = entry.output
          // +            (index == 0 ? 0 : arr[index-1].runningTotalHours)
          entry.rpm = Number(entry.rpm);
          entry.coolant_temp = Number(entry.coolant_temp);
          entry.soot_buildup = Number(entry.soot_buildup);
          entry.average_consumption = Number(entry.average_consumption);
      });

      // DEBUG: Make sure the data is how we want it:
      // console.log('After format'+this.chartLogs);
    },
    buildEffortChart(chartData) {
      Highcharts.chart(chartData+'Chart', {
            title: {
                text: 'Engine '+chartData
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Units'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Hours (Running Total)',
                // Data needs [ [date, num], [date2, num2 ], ... ]
                data: this.chartLogs.map( item => [item.convertDate, item[chartData]] )
            }]
        });
    }
  },
  created () {
    this.fetch_logs()
  }
}
);

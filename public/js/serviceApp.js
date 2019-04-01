var serviceApp=new Vue({
  el:'#serviceApp',
  data: {
    "siteId":0,
  "services":[
    {
       "service_id": 0,
       "pd_id": 0,
       "service_date": null,
       "summary": null,
       "health_grade": 0
   }
  ],
  post:{ },
  siteFound:"",
  turbineFound:""
},


  computed: {
  },
  methods:  {
    pretty_date: function (d) {
      return moment(d).format('l');
    },
    fetch_services(){
      // serviceApp.siteFound=this.siteId;
      fetch("https://cors.io/?http://ec2-34-222-136-163.us-west-2.compute.amazonaws.com/api/serviceHistory.php")
      // fetch("https://api.myjson.com/bins/19lt1q")
      // .then(function(response) { return response.json })
      .then( response => response.json())
      .then(json => {
        this.services = json;
        console.log('FETCHED JSON:');
        console.log(this.services);
        console.log('FETCHED JSON2:');
        console.log(this.services[1]);
      })
      .catch( function(err) {
        console.log('FETCH ERROR:');
        console.log(err);
      });
    }
  },
  created () {

  },
  mounted (){
    this.fetch_services();
  }
}
);

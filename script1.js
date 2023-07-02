// Check browser cache first, use if there and less than 10 seconds old
if(localStorage.when != null
    && parseInt(localStorage.when) + 310000> Date.now()) {
    let freshness = Math.round((Date.now() - localStorage.when)/1000) + " second(s)";
  var display_HTML= `
          <div class="container">
            <h1 class="title">Weather in ${localStorage.mycity}</h1>
            <h2 class="title_2">Todays Weather</h2>
            <div class="day_1">
            
              <div class="temp"> Temprature: <br>${localStorage.myTemperature}C</div><br>
              <div class="main">
                <div class="Weather-condition"> Today: ${localStorage.myWeather}</div>
                
                <div class="humidity">Humidity: ${localStorage.myHumidity} %</div>
                <div class="pressure">Pressure:${localStorage.mypressure} hpa </div>
                <div class="wind_desc">
                <div class="wind_speed">Wind-Speed:${localStorage.myWind} km/hr
                  <br>  direction: ${localStorage.mywind_Deg}°</div>
                </div>
        
               
               
             
               </div>
           
           
           </div> 
         </div>`
     
    // Copy one element of response to our HTML paragraph 
    document.getElementById("hacks").innerHTML= display_HTML;
    
    // No local cache, access network
    } else {
    // Fetch weather data from API for given city
    fetch('http://localhost:8000/my_api.php')
    // Convert response string to json object
    .then(response => response.json())
    .then(response => {
    const temp_1 = Math.round(response.weather_temperature-273);
    
    
    // Save new data to browser, with new timestamp
    localStorage.myWeather = response.weather_description;
    localStorage.myTemperature = temp_1+'°';
    localStorage.mycity=response.city;
    localStorage.mypressure=response.pressure;
    localStorage.myHumidity=response.Humidity;
    localStorage.mywind_Deg=response.wind_deg;
    localStorage.myWind=response.weather_wind; 

    localStorage.when = Date.now(); // milliseconds since January 1 1970
    })
    .catch(err => {
    // Display errors in console
    console.log(err);
    });
}
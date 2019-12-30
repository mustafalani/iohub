<!DOCTYPE html>
<meta charset='utf-8'>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.0.0.js" integrity="sha256-jrPLZ+8vDxt2FnE1zvZXCkCcebI/C8Dt5xyaQBjxQIo=" crossorigin="anonymous"></script>
<head>
<title>Facebook RTMP URL Obtainer</title>
<script>
  var fbid = "201130880631964";
  // Facebook SDK
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '201130880631964',
      xfbml      : true,
      version    : 'v2.6'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=201130880631964";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

   function auth(){
      FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
          console.log('Logged in.');
          rtmp();
        }
        else {
          FB.login(function(response) {
            if (response.authResponse) {
            rtmp();
          }
          else {
            $('#alert-cancelled').show();
          }
        });
      }
    });
  }

  function rtmp(){
    FB.ui({
      display: 'popup',
      method: 'live_broadcast',
      phase: 'create',
    },
    function(response) {
      if (!response.id) {
        return;
        $('#alert-cancelled').show();
      }
      console.log(response);
      document.getElementById('fb-rtmps').value = response.secure_stream_url;
      document.getElementById('fb-rtmp').value = response.stream_url;
      $('#alert-done').show();

     /* FB.ui({
        display: 'popup',
        method: 'live_broadcast',
        phase: 'publish',
        broadcast_data: response,
      },
      function(response) {
      });*/
    });
  }
</script>
</head>

<body>
  <div class="jumbotron">
    <div class="container">
      <h1>Facebook RTMP URL Obtainer</h1>
    </div>
  </div>

  <div class="container">
    <div class="alert alert-danger" role="alert"><b>Warning!</b>Do not block popup.</div>
    <button class="btn btn-primary" id="auth" onclick="auth()">Facebook Auth!</button><br/><br/>
    <div id="alert-auth" class="alert alert-info" role="alert">Click the Facebook Auth button to proceed.</div><br/>
    RTMP URL: <input disabled class="form-control" id="fb-rtmps"></input><br/>
    RTMP URL (Not recommended): <input disabled class="form-control" id="fb-rtmp"></input><br/>
    <div id="alert-done" style="display: none" class="alert alert-info" role="alert"><b>Done!</b> Now copy the RTMP URL into your preferred streaming application. Hope you enjoy! :D</div><br/>
    <div id="alert-failed" style="display: none" class="alert alert-danger" role="alert"><b>Cancelled!</b>Wanna restart? Refresh the page.</div>
    <hr/>
    <small>Made with love by <a href="https://srakrn.com">@srakrn</a></small>
    </div>
</body>

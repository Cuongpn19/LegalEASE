<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<title>Appointment form</title>
</head>
<body>
    <div class="container">
        
        <form action="{{route('client.store')}}" method="post"> 
            @csrf
            <div class="form-group">
                <label for="appointment_date">Appointment</label>
                <input id="appointment_date" class="form-control" type="datetime-local" name="appointment_date">
            </div>
            <div class="form-group">
                <label for="notes">Note</label>
                <input id="notes" class="form-control" type="text" name="notes">
            </div>
            <div class="form-group">
              <label for="">Luật sư:</label>
              <input type="text" name="" id="" class="form-control" aria-describedby="helpId">
              <small id="helpId" class="text-muted">Help text</small>
            </div>
            <button class="btn btn-success">Gửi</button>
        </form>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>
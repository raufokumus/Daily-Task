<!DOCTYPE html>
<html>
<head>
  <title>Calendar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
  <link rel="shortcut icon" href="main.svg">
</head>
<body>
  <div id="calendar"></div>

  <script>
    $(document).ready(function() {
      // Takvimin oluşturulması
      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        editable: false,
        events: 'get_events.php' // Görevleri alacak olan PHP dosyası
      });
    });
  </script>
</body>
</html>

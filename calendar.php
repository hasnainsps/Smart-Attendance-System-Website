<?php include_once('header.php'); ?>

<style>
        #calendar {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
    </style>

<section class="content">
    <div class="body_scroll">
        <div class="container-fluid">
            <div id="calendar"></div>
        </div>
    </div>
</section>

<?php include_once('footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
            display_events();
        });

function display_events() {
    var events = [];

    $.ajax({
        url: 'join_requests.php?calender=true&user_id=<?php echo $user_id;?>',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                var result = response.data;

                result.forEach(function(item) {
                    var startDate = dayjs(item.event_date + 'T' + item.start_time);
                    var endDate = dayjs(item.event_date + 'T' + item.end_time);

                    events.push({
                        title: item.event_title + ' (' + startDate.format('HH:mm') + ' - ' + endDate.format('HH:mm') + ' - ' + item.operation + ')',
                        start: startDate.toISOString(),
                        end: endDate.toISOString(),
                        color: 'blue'
                    });
                });

                var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                    plugins: ['dayGrid'],
                    defaultView: 'dayGridMonth',
                    events: events
                });

                calendar.render();
            } else {
                console.log('Error: ' + response.msg);
            }
        }
    });
}


</script>
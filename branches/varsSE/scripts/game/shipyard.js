var intervalIndex;
var intervalTimer;
var $firstElement;

function initTask()
{
    $firstElement = $('#queueList').children(':first');
    $firstElement.text(function(i, old) {
       return old + ' ' + bd_operating;
    });

	currentTaskAmount   = new DecimalNumber($firstElement.data('elements'), 0);
    $('#currentElementTimer').data('time', restTime / 1000).addClass('timerQueue');
    if(intervalTimer == null)
    {
        $('.timerQueue').text(function() {
            return GetRestTimeFormat(Math.max(0, $(this).data('time')))
        });

        intervalTimer = window.setInterval(function() {
            $('.timerQueue').text(function() {
                var secondsLeft		= $(this).data('time') - 1;
                $(this).data('time', secondsLeft);
                return GetRestTimeFormat(Math.max(0, secondsLeft));
            });
        }, 1000);
    }

	window.setTimeout(function() {
        shipyardInterval();
        intervalIndex	= window.setInterval(shipyardInterval, $firstElement.data('buildtime') * 1000)
    }, restTime);
}

function shipyardInterval()
{
    currentTaskAmount.sub('1');

    $('#currentElementTimer').data('time', $firstElement.data('buildtime') + 1);

    $('#val_'+$firstElement.data('element')).text(function(i, old){
        return ' ('+bd_available + NumberGetHumanReadable(parseInt(old.replace(/.* (.*)\)/, '$1').replace(/\./g, '')) + 1)+')';
    });

    if (currentTaskAmount.toString() == '0')
    {
        $firstElement.remove();
        var $queueList  = $('#queueList');
        window.clearInterval(intervalIndex);
        if ($queueList.length == 0)
        {
            $queueList.html('<option>'+Ready+'</option>');
            document.location.href	= document.location.href;
        }

        restTime = $queueList.children(':first').data('buildtime') * 1000;
        initTask()
    }
    else
    {
        $firstElement.text(function(i, old) {
            return old.replace(/^[0-9]+ (.*)$/, currentTaskAmount.toString()+' $1');
        });
    }
}
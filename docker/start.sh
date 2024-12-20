set -e

role=${CONTAINER_ROLE:-app}
#work_on_queues=${WORK_ON_QUEUES:-default}

if [ "$role" = "app" ]; then
    /usr/bin/supervisord -c /etc/supervisord.conf

#elif [ "$role" = "queue" ]; then
#
#    echo "Running the queue..."
#    php /var/www/artisan queue:work --queue="$work_on_queues" --sleep=3 -v --timeout=3600
#
#elif [ "$role" = "scheduler" ]; then
#
#    echo "Running the scheduler..."
#    php /var/www/artisan schedule:work

else
    echo "Could not match the container role \"$role\""
    exit 1
fi

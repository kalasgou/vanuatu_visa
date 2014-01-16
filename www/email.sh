#/bin/sh
#segment to unicase

#broad to segment

#push unicase
PROCESS_NUM=`ps -ef | grep "index.php pns deliver push_msgs" | grep -v "grep" | wc -l`
while [ $PROCESS_NUM -lt  6 ] 
do
	PROCESS_NUM=`expr $PROCESS_NUM + 1`
    /usr/bin/nohup /usr/bin/php -f /var/appletree.cn/innerapi/www/index.php pns deliver push_msgs > /dev/null 2>&1 &
done

exit

*/5 * * * * /var/appletree.cn/innerapi/application/controllers/crontab/pns.sh > /dev/null
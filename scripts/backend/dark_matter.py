# ==================================================================================\\
# ~TheRavikin |  theravikin.pl | mail at: scripts@theravikin.pl    		    ||
#	TO DO:									    ||
#       x       - work about logging actions to the file                            ||
#	x	- change limit hisotry or change it completly                       ||
#	x	- change black matter multiplayer				    ||
#	x	- need to adjust multiplier depending on currency SBD or STEEM 	    ||
#       DONE:                                                                       ||
#	v	- change SQL query						    ||
# ==================================================================================//
from steem import Steem
from datetime import datetime
from pathlib import Path
import MySQLdb
import csv, os

# Some global vars
# ----------------
_json = ""
_time = datetime.now().isoformat(timespec='seconds')
_date = datetime.now().strftime("%d%m%y")
_database = ''
_cursor = ''

_logfile = "/tmp/steemnova/"+_date+".csv"
_lastpaid = "/tmp/steemnova/lastpaid.txt"

_table_name = "" #dbname.prefix_users


# Some funcions
# -------------

# big ones

## opening steem object
def init():
    global _json
    global _database
    global _mariadb_connection

    s = Steem()		

    _database = MySQLdb.connect(host="localhost", user="unova", passwd="password", db="NOVADB") # db username, db user pass, db name
    															# steeming it up!
    try:
        _json = s.get_account_history('steemnova', -1, limit=300)				# getting account history
    except :
        raise NameError("init() faild at downloading history. \tData response:\n\t "+data)	

## some magic
def get_transfers():
    for __item in _json:															# for top json item
        if __item[1]['op'][0] == "transfer":										# search for transfers
            if __item[1]['op'][1]['memo'] == "ZGFya21hdHRlcgo":							# and for steemnova darkmatter top-ups
                __transaction_timestamp = __item[1]['timestamp']			
                __player = __item[1]['op'][1]['from']			
                __amount_recived = __item[1]['op'][1]['amount'].partition(' ')[0]
                __dark_matter_to_send = int(round(float(__amount_recived) * 300, 2))													# HOW much darkmatter player will get
                print("DBG Player {} has sent {} and will recive {}".format(__player, __amount_recived, __dark_matter_to_send))
                log("GT;{0};{1};{2};{3}".format(__transaction_timestamp, __player, __amount_recived, __dark_matter_to_send)+'\n')	# loginng for future

## here comes less magic
def pay_users(__user, __amount, __timestamp, _database): 
    global _cursor
    _cursor = _database.cursor()
    __query = "UPDATE {0} SET darkmatter=(darkmatter+{1}) WHERE username='{2}'".format(_table_name, __amount, __user)
    #          UPDATE <table_name> SET darkmatter=darkmatter+<amount> WHERE username=<player>	
    print(__query)
    _cursor.execute(__query);	                                                        	# add dark matter to the users

    print("#DGB PU;{0};{1};{2}".format(_time, __user ,__amount)+'\n')					# and inform about it ;D # TODO
    with open(_lastpaid, 'w') as f:										#  \  
        f.write(__timestamp)													#	update last paid timestamp
	
## aaand here comes the truth!
def rotate():
    with open(_lastpaid, 'r') as __lastpaid:
        __lastpaid_date = __lastpaid.readline()
        with open(_logfile) as __csvfile:
            line = csv.DictReader(__csvfile, delimiter=';')
            for row in line:
                if row['timestamp'] > __lastpaid_date:						   # if player wasn't paid yet he is getting paid (english.... -.-)
                    pay_users(row['player'], row['darkmatter'], row['timestamp'], _database)

# little ones

def cleanup():
    global _database
    _database.close()

## just log into file
def log(__line):
    print(_logfile, __line)
    __logfile = Path(_logfile)
    if __logfile.exists(): 														# checking for logfile existance
        with open(_logfile, 'a') as f:											# if exists then just append new line
            print("#DBG logfile exists - just logging")
            f.write(__line)
    else:																		# if not then create new one with CSV header
        with open(_logfile, 'w') as f:
            print("#DBG logfile does not exists - making csv header and logging")
            f.write("function;timestamp;player;recived;darkmatter"+'\n')
            f.write(__line)

# ________
# | MAIN |
# \/\/\/\/

print("init()")
init()                  # initiating DB connection and Steem blockchain
print("init() done")

print("get transfers()")
get_transfers()         # loading steemnova transcations
print("get transfers() done")

print("rotate()")
rotate()                # giving money to ppl
print("rotate() done")

cleanup()               # closing db connection

# SteemNova
My contribution to SteemNova project managed by @fervi & @mys
http://steemnova.intinte.org

## dark_matter.py (tested only by @me)
It's a script for automated black matter inserting into player accounts.
Player transfers SBD or STEEM to the @Steemnova account and the rest is handled by this little monster

### Dependencies
- `python MySQLdb`
- `python steem`

### Functions & How does it work?
1. init()
	* init() initiates the DB connection with given credentials and also STEEM blockchain by Steem()
	* it is also downloading whole acc history with given limit to the glob. var. `_json`
1. get_transfers()
	* this function is taking only `transactions` from whole account history and it's logging it to the csv file for future payments
	* also here is the multiplier for Dark Matter to pay
	* it saves with given \*.csv header
		* function prefix;transaction timestamp;recived from;amount recived;dm amount to add
		* `function;timestamp;player;recived;darkmatter`
1. pay_users(String username, int amount_to_pay, String timestamp, DB object)			# YEEEEEP, i know it's pyhon and var. types are handled by *the snake* but it's easier to understand what arguments are given
	* it makes SQL query to update user table with given amount_to_pay
	* and executes it, also updates the `lastpaid` file as flag which transactions were paid
1. rotate()
	* it has strange name but it it the BRAIN
	* it is taking lastpaid timestamp and compares it to the transaction timestamp
	* if transaction is LATER than FLAG it will pay
	* it htink...
1. log(String line)
	* it takes string to log into `logfile`
1. cleanup() 
	* after job is done it disconects from DB


### TO DO
- [ ] init() 			- change loaded transactions limit or change it totally if ther's better way
- [ ] get_transfers()	- change black matter multiplier to adequate digits (\*10 for exqmple or even more... guys?)
- [ ] get_transfers() 	- need to adjust multiplier depending on currency SBD or STEEM 
- [ ] get_transfers() 	- maybe separate validating transactions from payment logic (?) # for tuture enhancment [probably never xd]
- [ ] in general 		- handle the excepotions handlers
- [ ] in general			- make more data validation to prevent injections & negative numbers
- [x] @theravikin **take a nap.**





`IN LATER DEVELOPMENT STATE`
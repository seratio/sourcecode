from subprocess import call
call(["geth", "--datadir", "ethereum_private", "--password", "Pass.txt", "account", "new"])
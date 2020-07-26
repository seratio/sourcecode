from subprocess import call
# geth --fast --cache 512 --ipcpath ~/Library/Ethereum/geth.ipc --networkid 1234 --datadir ethereum_private --mine
call(["ethminer", "-U"])
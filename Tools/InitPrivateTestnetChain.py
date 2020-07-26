from subprocess import call
call(["geth", "--datadir", "ethereum_private", "init", "genesis_block.json"])
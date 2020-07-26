from subprocess import call
call([
    "geth",
    "--cache", "512",
    "--rpccorsdomain", "*",
    "--rpc",
    "--rpcport", "8042",
    "--networkid", "42",
    "--datadir", "ethereum_private",
    "--mine",
    "--minerthreads", "1",
    "--unlock", "0,1",
    "--password", "Pass.txt",
    "--etherbase", "0",
    "console"
])

# call([
#     "geth",
#     "--cache", "22000",
#     "--rpccorsdomain", "*",
#     "--rpc",
#     "--rpcport", "8045",
#     "--networkid", "1",
#     "--unlock", "0,1",
#     "--password", "Pass.txt",
#     "--etherbase", "1",
#     "console"
# ])

# # Rinkeby
# call([
#     "geth",
#     "--cache", "22000",
#     "--fast",
#     "--unlock", "0,1",
#     "--password", "Pass.txt",
#     "--etherbase", "1",
#     "--rinkeby",
#     "--rpc",
#     "--rpcapi",  "db","eth","net","web3","personal"
# ])
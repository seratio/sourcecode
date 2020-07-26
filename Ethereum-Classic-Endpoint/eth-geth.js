const { spawn } = require('child_process');
//worker: ./geth --rpc --shh --rpcapi "web3,shh,eth"
const geth = spawn('geth', ['--port', '30403', '--rpcport', '8645', '--wsport', '8646', '--pprofport', '6160', '--mine', '--rpc','--rpcaddr', '0.0.0.0', '--shh', '--rpcapi', "web3,shh,personal,eth", '--fast', '--cache=128']);

geth.stdout.on('data', (data) => {
    console.log(`${data}`);
});

geth.stderr.on('data', (data) => {
    console.log(`${data}`);
});

geth.on('close', (code) => {
    console.log(`child process exited with code ${code}`);
});

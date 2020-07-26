var HDWalletProvider = require("truffle-safe-hdwallet-provider");
var EthCrypto = require('eth-crypto');

async function Execute() {
    var _mnemonic = process.argv[3];
    var _action = process.argv[2];
    var _data = process.argv[4];
    var _provider = new HDWalletProvider(_mnemonic, "http://localhost:8545", 0, 1, 'bewithme');
    var _privateKey = _provider.wallets[_provider.addresses[0]]._privKey.toString('hex');
    var _publicKey = _provider.wallets[_provider.addresses[0]]._pubKey.toString('hex');
    var _result = "Error";

    if (_action == 'encrypt') {
        _result = EthCrypto.cipher.stringify(await EthCrypto.encryptWithPublicKey(_publicKey, _data));
        console.log(_result);
    } else if (_action == 'decrypt') {
        _result = await EthCrypto.decryptWithPrivateKey(_privateKey, EthCrypto.cipher.parse(_data));
        console.log(_result);
    } else if (_action == 'test') {
        var _encObj = await EthCrypto.encryptWithPublicKey(_publicKey, _data);
        var _encString = EthCrypto.cipher.stringify(_encObj);
        console.log(_encString);
        var _tmp = EthCrypto.cipher.parse(_encString);
        _result = await EthCrypto.decryptWithPrivateKey(_privateKey, _tmp);
        console.log(_result);
    } else {
        console.log('Unknown');
    }
}

Execute();
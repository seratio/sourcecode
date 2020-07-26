#To start:
```pm2 process.yml```

#To test
```curl -X POST --data '{"jsonrpc":"2.0","method":"eth_blockNumber","params":[],"id":1}' http://108.61.174.108:8000/api```

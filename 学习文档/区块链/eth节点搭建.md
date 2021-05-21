# eth节点搭建

## 1.安装go

```bash
    yum update -y && yum install git wget bzip2 vim gcc-c++ ntp epel-release nodejs cmake -y
    wget https://dl.google.com/go/go1.15.linux-amd64.tar.gz
    tar -C /usr/local -xzf go1.15.linux-amd64.tar.gz
    echo 'export GOROOT=/usr/local/go' >> /etc/profile  
    echo 'export PATH=$PATH:$GOROOT/bin' >> /etc/profile  
    echo 'export GOPATH=/root/go' >> /etc/profile
    echo 'export PATH=$PATH:$GOPATH/bin' >> /etc/profile
    source /etc/profile
    go version
```

## 2.安装geth

 ```bash
    git clone https://github.com/ethereum/go-ethereum.git
    cd go-ethereum
    make geth
    echo 'export PATH=$PATH:/opt/go-ethereum/build/bin' >> /etc/profile
    source /etc/profile
    geth version
```


## 3.启动

```bash
    nohup geth --rpc --rpcapi 'db,eth,net,web3,personal' --rpcaddr '0.0.0.0' --rpcport 9508 --datadir /root/gethData/ --cache 512 console 2>> /root/gethData/geth.log
    
    --allow-insecure-unlock  #允许http解锁账户
```

## 4.测试私链

 ```bash
 geth --datadir {eth_dir} account new
 vim  genesis.json
 {
  "config": {
    "chainId": 666,
    "homesteadBlock": 0,
    "eip150Block": 0,
    "eip150Hash": "0x0000000000000000000000000000000000000000000000000000000000000000",
    "eip155Block": 0,
    "eip158Block": 0,
    "byzantiumBlock": 0,
    "constantinopleBlock": 0,
    "petersburgBlock": 0,
    "istanbulBlock": 0,
    "ethash": {}
  },
  "nonce": "0x0",
  "timestamp": "0x5ddf8f3e",
  "extraData": "0x0000000000000000000000000000000000000000000000000000000000000000",
  "gasLimit": "0x47b760",
  "difficulty": "0x00002",
  "mixHash": "0x0000000000000000000000000000000000000000000000000000000000000000",
  "coinbase": "0x0000000000000000000000000000000000000000",
  "alloc": { },
  "number": "0x0",
  "gasUsed": "0x0",
  "parentHash": "0x0000000000000000000000000000000000000000000000000000000000000000"
}
geth --datadir {eth_dir}  init  {./genesis.json}
 ```

## 4.参考

* [文档](https://blog.csdn.net/qq_35753140/article/details/79463735)
* [文档](https://geth.ethereum.org/docs/)
* [文档](https://www.cnblogs.com/hzhuxin/p/9962493.html)



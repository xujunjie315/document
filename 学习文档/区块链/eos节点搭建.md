# eos节点搭建

## 1.安装eosio

```bash
    wget https://github.com/EOSIO/eos/releases/download/v1.8.5/eosio-1.8.5-1.el7.x86_64.rpm
    sudo yum install ./eosio-1.8.5-1.el7.x86_64.rpm
```

## 2.启动keosd

```bash
    keosd --http-server-address 0.0.0.0:8889 &
```

## 3.启动nodeos测试节点

```bash
    nodeos \
    -e -p eosio \
    --plugin eosio::producer_plugin \
    --plugin eosio::chain_api_plugin \
    --plugin eosio::http_plugin \
    --plugin eosio::history_plugin \
    --plugin eosio::history_api_plugin \
    --filter-on="*" \
    --access-control-allow-origin='*' \
    --contracts-console \
    --http-validate-host=false \
    --http-server-address=0.0.0.0:8888 \
    --data-dir /data/eos/data/ \
    --verbose-http-errors >> /data/eos/nodeos.log 2>&1 &
```

* 重启错误

```bash
    --replay-blockchain \
    --hard-replay-blockchain \
```

## 4.nodeos正式节点接入主网

```bash
    vim config.ini   内容：https://github.com/CryptoLions/EOS-MainNet/blob/master/config.ini       
    vim genesis.json 内容：https://github.com/CryptoLions/EOS-MainNet/blob/master/genesis.json
    nodeos \
    -e \
    --plugin eosio::producer_plugin \
    --plugin eosio::chain_api_plugin \
    --plugin eosio::http_plugin \
    --plugin eosio::history_plugin \
    --plugin eosio::history_api_plugin \
    --data-dir /root/eos/data \
    --config-dir /root/eos \
    --genesis-json /root/eos/genesis.json >> /root/eos/nodeos.log 2>&1 &
```

## 5.参考

* [文档](https://developers.eos.io/eosio-home/docs)
* [文档](https://developers.eos.io/eosio-home/docs)


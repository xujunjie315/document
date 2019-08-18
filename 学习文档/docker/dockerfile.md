# dockerfile

## 1.设置基础镜像

```bash
FROM <image>或 FROM <image>:<tag>
```

## 2.指定维护者的信息

```bash
MAINTAINET <name>
```

## 3.运行命令

```bash
RUN <command> 或 RUN ["", "", ""]
```

## 4.指定启动容器时执行的命令，每个Dockerfile只能有一条CMD指令，如果指定了多条指令，则最后一条执行。

```bash
CMD ["","",""]
```

## 5.告诉Docker服务端暴露端口

```bash
EXPOSE <port>  [ <port> ...]
```

## 6.指定环境变量

```bash
ENV <key> <value>
```

## 7.复制指定的<src>到容器的<dest>中

```bash
ADD  <src>  <dest>
```

## 8.复制本地主机的 <src> 到容器中的 <dest>

```bash
COPY <src>  <dest>
```

## 9.配置容器启动后执行的命令，并且不可被 docker run 提供的参数覆盖。

```bash
ENTRYPOINT ["","",""]
```

## 10.创建一个可以从本地主机或其他容器挂载的挂载点

```bash
VOLUME ["/mnt"]
```

## 11.指定运行容器时的用户名或 UID

```bash
USER daemon
```

## 12.为后续的 RUN 、 CMD 、 ENTRYPOINT 指令配置工作目录

```bash
WORKDIR /path/to/workdir
```

## 13.配置当所创建的镜像作为其它新创建镜像的基础镜像时，所执行的操作指令

```bash
ONBUILD [INSTRUCTION]
```

## 14.参考

* [文档](https://www.cnblogs.com/niloay/p/6261784.html)
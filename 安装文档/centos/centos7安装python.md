# 使用 pyenv 在 CentOS7 下部署 Python 生产环境

## 1 修改历史

日期|修改人|备注
-|-|-
2018-10-20|尹绍彬|首次创建

pyenv是python版本控制及虚拟环境的软件，生产系统中必须部署，以避免python版本和python包冲突。

## 2 CentOS7 系统软件安装

* 安装 wget, curl, git

  ```bash
  yum -y install wget
  yum -y install curl
  yum -y install git
  ```

## 3 安装配置 pyenv

* 通过脚本安装

  ```bash
  curl -L https://github.com/pyenv/pyenv-installer/raw/master/bin/pyenv-installer | bash
  ```

* 执行完成后，根据提示将以下代码加入到 ~/.bashrc 中
* 以下代码为示例，请根据 **实际提示** 处理

  ```bash
  export PATH="~/.pyenv/bin:$PATH"
  eval "$(pyenv init -)"
  eval "$(pyenv virtualenv-init -)"
  ```

* 之后执行 source

  ```bash
  source ~/.bashrc
  ```

* 到这里 pyenv 基本安装完成，具体 pyenv 命令可以去查看参考链接 pyenv

## 通过 pyenv 安装 python

* 由于 pyenv 安装 python 的方式是下载源码构建的，因此我们需要先安装好构建需要的 yum 包

  ```bash
  yum install gcc make patch gdbm-devel openssl-devel sqlite-devel readline-devel zlib-devel bzip2-devel libffi-devel -y
  ```

* 安装完成 yum 包后就可以通过 pyenv 来安装 python 了

  ```bash
  # 列出可以安装的 python 版本列表
  pyenv install -list

  # 安装 python 3.7.0 版
  pyenv install 3.7.0 -v

  # 查看是否安装成功
  pyenv versions
  ```

* pyenv 使用 global, shell, local 三个命令来切换 python 版本， global:基于全局切换，shell:基于当前会话切换，local:基于文件夹切换

  ```bash
  pyenv global 3.7.0
  pyenv shell 3.7.0
  pyenv local 3.7.0
  ```

## 4 安装和使用虚拟环境

* 执行以下命令安装虚拟环境，3.7.0为 python 版本，flaskapp 为该虚拟环境的别名

  ```bash
  pyenv virtualenv 3.7.0 flaskapp
  ```

* 安装完成后，就可以在需要的目录下执行 pyenv local flaskapp 指定该目录需要的虚拟环境了

  ```bash
  pyenv local flaskapp
  cd ~/pyprojects/flashapp
  pyenv local flaskapp
  ```

* 成功后，在进入该目录时，提示符最前会有 (flaskapp) 这样的提示信息，表示已进入 flaskapp 虚拟环境

  ```bash
  (flaskapp) [yin@MiWiFi-R1CM-srv flaskapp]$
  ```

## 5 为 pip 指定国内镜像源

* 建立 pip 配置文件

  ```bash
  # 在 HOME 目录下新建 .pip 文件夹
  mkdir .pip
  cd .pip

  # 在 .pip 文件夹下新建 pip.conf 文件
  touch pip.conf
  vi pip.conf
  ```

* 将下面的代码加入 pip.conf 中

  ```ini
  [global]
  index-url=https://mirrors.aliyun.com/pypi/simple/
  trusted-host=mirrors.aliyun.com
  ```

* 安装完成后就可以使用 阿里云 的源安装 pip 包了

## 6 参考

[pyenv](https://github.com/pyenv/pyenv)  
[pyenv-installer](https://github.com/pyenv/pyenv-installer)
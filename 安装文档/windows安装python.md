# windows 系统下 python 开发环境的安装

## 1 下载并安装python

* [python官网](https://www.python.org/)

* [下载](https://www.python.org/downloads/windows/) 

## 2 virtualenv 虚拟环境安装

* 使用 pip 安装 virtualenv

  ```bash
  pip3 install virtualenv
  ```

## 3 创建虚拟目录

  ```bash
  mkdir flaskapp
  cd flaskapp
  virtualenv --no-site-packages venv
  ```
## 4 启动虚拟目录
* 安装完成后，可以执行以下命令启动虚拟环境

  ```bash
  ./venv/Scripts/activate.ps1
  ```

* 启动成功后提示符最前会有 (flaskapp) 这样的提示信息，表示已进入 flaskapp 虚拟环境
  
* 之后可以在当前虚拟环境内通过 pip 安装 python 包

  ```bash
  pip install flask
  ```

## 5 为 pip 指定国内镜像源

* 建立 pip 配置文件

  ```bash
  # 在 HOME 目录下新建 pip 文件夹
  mkdir pip
  cd pip

  # 在 pip 文件夹下新建 pip.ini 文件
  New-Item pip.ini -Type File
  code pip.ini
  ```

* 将下面的代码加入 pip.ini 中

  ```ini
  [global]
  index-url=https://mirrors.aliyun.com/pypi/simple/
  trusted-host=mirrors.aliyun.com
  ```

* 安装完成后就可以使用 阿里云 的源安装 pip 包了

## 6 参考

* [virtualenv 官方文档](https://virtualenv.pypa.io/en/latest/)
* [virtualenv 安装和使用](https://www.liaoxuefeng.com/wiki/1016959663602400/1019273143120480)
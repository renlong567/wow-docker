# WOW - TrinityCore:3.3.5

> 无需梯子可直接编译

## 版本说明

- 基础版: 使用 TrinityCore:3.3.5 最新源码编译构建

- 进阶版: 使用 TrinityCore:3.3.5 与 TrinityBots 最新源码编译构建

## 准备工作

- 编译机:  linux  docker  (wsl通过测试)

- 地图数据:  下载
  
  > 地图数据解压后放置指定目录
  > 
  >  /wow-docker
  > 
  >     |-- app
  > 
  >         |-- client_data
  > 
  >             |-- Cameras
  > 
  >             |-- dbc
  > 
  >             |-- maps
  > 
  >             |-- vmaps

## 编译&启动

### 基础版

> 编译

```bash
docker build -t wow:3.3.5 -f TrinityCore-3.3.5/Dockerfile TrinityCore-3.3.5;
```

> 启动

```bash
docker run --rm -it \
    -v /wow-docker/app:/appdata \
    --name wow \
    -p 8085:8085 -p 3724:3724 -p 3306:3306 \
    -e EXTERNAL_ADDRESS=127.0.0.1 \
    wow:3.3.5
```

### 进阶版

> 编译

```bash
docker build -t wow:3.3.5-bot -f TrinityCore-Bot-3.3.5/Dockerfile TrinityCore-Bot-3.3.5
```

> 启动

```bash
docker run --rm -it \
    -v /wow-docker/app:/appdata \
    --name wow \
    -p 8085:8085 -p 3724:3724 -p 3306:3306 \
    -e EXTERNAL_ADDRESS=127.0.0.1 \
    wow:3.3.5-bot
```

# 申明

1. 请勿使用在商业用途中。
2. 项目为开源项目,仅供技术探讨使用。

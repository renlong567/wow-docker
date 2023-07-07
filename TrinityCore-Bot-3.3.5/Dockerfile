FROM ubuntu:20.04

ARG mirror
ARG branch=3.3.5

RUN sed -i s@/archive.ubuntu.com/@/mirrors.aliyun.com/@g /etc/apt/sources.list && \
apt-get update && \
DEBIAN_FRONTEND=noninteractive apt-get install -y git clang cmake make gcc g++ libmysqlclient-dev libssl-dev libbz2-dev libreadline-dev libncurses-dev libboost-all-dev mysql-server p7zip curl jq vim && \
			update-alternatives --install /usr/bin/cc cc /usr/bin/clang 100 && \
			update-alternatives --install /usr/bin/c++ c++ /usr/bin/clang 100

RUN cd ~/ && \
	# -下载源码--
	git clone -b ${branch} --depth 1 ${mirror}https://github.com/TrinityCore/TrinityCore.git && \
	git clone --depth 1 ${mirror}https://github.com/trickerer/Trinity-Bots.git && \
	cd ~/TrinityCore && \
	# -机器人补丁--
	cp ~/Trinity-Bots/NPCBots.patch . && \
	mv ~/Trinity-Bots/SQL sql/Trinity-Bots && \
	cp sql/Trinity-Bots/updates/characters/* sql/updates/characters/$trinitycore_branch && \
	cp sql/Trinity-Bots/updates/world/* sql/updates/world/$trinitycore_branch && \
	rm -rf ~/Trinity-Bots && \
	patch -p1 < NPCBots.patch && \
	# -构建源码--
	mkdir build && \
	cd build && \ 
	cmake ../ -DCMAKE_INSTALL_PREFIX=/server && \
	make -j $(nproc) install && \
	# -sql文件--
	cd .. && \
	mv sql .. && \ 
	rm -rf * && \
	mv ../sql . && \
	# -下载sql文件
	mkdir ~/TDB && \
	cd ~/TDB && \
	curl -o TDB_full_world_335.7z ${mirror}`curl -s https://api.github.com/repos/TrinityCore/TrinityCore/releases | jq -r "first(.[]|select(.target_commitish | test(\"3.3.5\")) )| .assets[0].browser_download_url"` && \
	7zr x TDB_full_world_335.7z && \
	mv *.sql /server/bin && \
	cd / && \
	rm -rf ~/TDB
	# -删除安装的程序
	#apt-get remove -y git clang cmake make gcc g++ libmysqlclient-dev libssl-dev libbz2-dev libreadline-dev libncurses-dev libboost-all-dev mysql-server default-libmysqlclient-dev jq

VOLUME /data/wow-docker/appdata

COPY entrypoint.sh /

RUN chmod +x entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

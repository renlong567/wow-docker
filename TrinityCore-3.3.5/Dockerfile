FROM debian:10

RUN sed -i 's/deb.debian.org/mirrors.163.com/g' /etc/apt/sources.list && sed -i 's/security.debian.org/mirrors.163.com/g' /etc/apt/sources.list && \
	apt-get update && \
	apt-get install -y git clang cmake make gcc g++ libmariadbclient-dev libssl-dev libbz2-dev libreadline-dev libncurses-dev \
			libboost-all-dev mariadb-server p7zip default-libmysqlclient-dev curl jq && \
	update-alternatives --install /usr/bin/cc cc /usr/bin/clang 100 && \
	update-alternatives --install /usr/bin/c++ c++ /usr/bin/clang 100 && \
	rm -rf /var/lib/apt/lists/*

ARG trinitycore_branch=3.3.5
ARG trinitycore_git=https://hub.fastgit.org/TrinityCore/TrinityCore.git


RUN cd ~/ && \
	git clone -b $trinitycore_branch --depth 1 $trinitycore_git && \
	cd ~/TrinityCore && \
	mkdir build && \
	cd build && \
	cmake ../ -DCMAKE_INSTALL_PREFIX=/server && \
	make -j $(nproc) install && \
	cd .. && \
	mv sql .. && \
	rm -rf * && \
	mv ../sql .

RUN mkdir ~/TDB && \
	cd ~/TDB && \
	curl -o TDB_full_world_335.7z 'https://ghproxy.fsou.cc/'`curl -s https://api.github.com/repos/TrinityCore/TrinityCore/releases | jq -r "first(.[]|select(.target_commitish | test(\"3.3.5\")) )| .assets[0].browser_download_url"` && \
	7zr x TDB_full_world_335.7z && \
	mv *.sql /server/bin && \
	cd / && \
	rm -rf ~/TDB

RUN sed -i "s/\/var\/lib\/mysql/\/appdata\/db_data/g" /etc/mysql/mariadb.conf.d/50-server.cnf


RUN apt-get remove -y git clang cmake make gcc g++ libmariadbclient-dev libssl-dev libbz2-dev libreadline-dev libncurses-dev \
		libboost-all-dev mariadb-server p7zip default-libmysqlclient-dev curl jq

VOLUME /appdata

COPY entrypoint.sh /

RUN chmod +x entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

FROM java:openjdk-7-jre

ENV LIQUIBASE_URL=https://github.com/liquibase/liquibase/releases/download/liquibase-parent-3.5.1/liquibase-3.5.1-bin.tar.gz

RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        libmysql-java \
    && \
    rm -r /var/lib/apt/lists/*

RUN wget -q --no-check-certificate ${LIQUIBASE_URL} -O /tmp/liquibase-bin.tar.gz \
    && mkdir -p /opt/liquibase \
    && tar -xzf /tmp/liquibase-bin.tar.gz -C /opt/liquibase \
    && chmod +x /opt/liquibase/liquibase \
    && ln -s /opt/liquibase/liquibase /usr/local/bin/

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

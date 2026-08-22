#!/bin/bash

set -e

a2dismod mpm_event mpm_worker mpm_prefork || true
a2enmod mpm_prefork

exec apache2-foreground

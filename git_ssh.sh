#!/bin/sh
exec ssh -o IdentityFile=~/.ssh/id_rsa "$@"

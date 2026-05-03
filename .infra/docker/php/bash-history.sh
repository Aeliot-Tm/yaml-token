# Append shell history to HISTFILE after each command (use with HISTFILE on a bind-mounted path).
# histappend avoids one session overwriting the whole history file on exit.
# Sourced only from ~/.bashrc in this image (see Dockerfile).
shopt -s histappend 2>/dev/null || true
PROMPT_COMMAND="history -a${PROMPT_COMMAND:+; $PROMPT_COMMAND}"

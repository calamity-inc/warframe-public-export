<?php
passthru("git commit -m ".escapeshellarg(file_get_contents("https://conduit.browse.wf/current-version")));

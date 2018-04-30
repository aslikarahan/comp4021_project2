<?php
if (isset($_cookie['username']))
unset($_cookie['username']);
if (isset($_session['username']))
usnset($_session['username']);
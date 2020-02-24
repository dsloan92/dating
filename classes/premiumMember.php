<?php

class PremiumMember extends Member
{
    private $_inDoorInterests;
    private $_outDoorInterests;

    function setInDoorInterests($inDoor)
    {
        $this->_inDoorInterests = $inDoor;
    }

    function setOutDoorInterests($outDoor)
    {
        $this->_outDoorInterests = $outDoor;
    }

    function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }
}

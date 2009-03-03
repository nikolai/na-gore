<?php

/**
 * Description of ArchieveProviderFactory
 *
 * @author HauBHbIE
 */
class ArchieveProviderFactory {
    function createProvider() {
        return new ArchieveProviderImpl();
    }
}
?>

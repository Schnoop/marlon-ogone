<?php
/*
 * This file is part of the Marlon Ogone package.
 *
 * (c) Marlon BVBA <info@marlon.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ogone\Ecommerce;

use Ogone\AbstractPaymentRequest;
use Ogone\DirectLink\PaymentOperation;
use Ogone\ShaComposer\ShaComposer;

class EcommercePaymentRequest extends AbstractPaymentRequest
{

    const TEST = "https://secure.ogone.com/ncol/test/orderstandard_utf8.asp";
    const PRODUCTION = "https://secure.ogone.com/ncol/prod/orderstandard_utf8.asp";

    public function __construct(ShaComposer $shaComposer)
    {
        $this->shaComposer = $shaComposer;
        $this->ogoneUri = self::TEST;
    }

    public function getRequiredFields()
    {
        return array(
            'pspid', 'currency', 'amount', 'orderid'
        );
    }

    public function getValidOgoneUris()
    {
        return array(self::TEST, self::PRODUCTION);
    }

    public function setAlias(Alias $alias)
    {
        $this->parameters['aliasoperation'] = $alias->getAliasOperation();
        $this->parameters['aliasusage'] = $alias->getAliasUsage();
        $this->parameters['alias'] = $alias->getAlias();
    }

    protected function getValidOperations()
    {
        return array(
            PaymentOperation::REQUEST_FOR_AUTHORISATION,
            PaymentOperation::REQUEST_FOR_DIRECT_SALE,
            PaymentOperation::REQUEST_FOR_PRE_AUTHORISATION,
        );
    }
}

<?php
namespace Orderhistoryextend\Orderextend\Model;
use Orderhistoryextend\Orderextend\Api\OrderextendInterface;
use Magento\Framework\App\ObjectManager;


/* protected $_productRepositoryFactory;
 
 public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory
) {

    $this->_productRepositoryFactory = $productRepositoryFactory;
}
 */
class Orderextend implements OrderextendInterface
{
   

    public function customerid($id) {
		
		
		                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		
		              $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
		              $baseurl = $storeManager->getStore()->getBaseUrl();	
                  
		   if ($id) { 

					
					//$id = $customer->getId();
					$orderDatamodel = $objectManager->get('Magento\Sales\Model\Order')->getCollection()->addFieldToFilter('customer_id', ['eq' => "$id"])->setOrder('increment_id','DESC');; 
					 $orderresult = array();
					     $counter=count($orderDatamodel); 
			  // echo $counter;
			   if($counter !=0){
					foreach($orderDatamodel as $orderDatamodel1) { 
						$orderdetail = array();  
						
						//print_r($orderDatamodel1->getData());  

						//$getid =  $orderDatamodel1->getData("increment_id");         
						//$orderData = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($getid);         	    
						//$getorderdata = $orderData->getData(); 

						$orderItems1 = $orderDatamodel1->getAllVisibleItems(); 
						$product_information = array();
						foreach($orderItems1 as $orderItems){   
							$product_details = array();
						    $productId =	$orderItems->getData('product_id'); 
						    $store = $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore();
							$_product = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);
							$imageUrl = $baseurl.'pub/media/catalog/product'. $_product->getImage();

							//$product = $this->productFactory->create()->load($productId);
							$product_details['name'] = $orderItems->getData('name');
							$product_details['sku'] = $orderItems->getData('sku');
							$product_details['price'] = $orderItems->getData('price');
							$product_details['qty'] = $orderItems->getData('qty_ordered');
							$product_details['total_price'] = $orderItems->getData('row_total');
							$product_details['image'] = $imageUrl;
							$product_information[] = $product_details;
						}
						
						$orderdetail['order_number'] = $orderDatamodel1->getData('increment_id');
						$orderdetail['created_at'] = $orderDatamodel1->getData('created_at');
						$orderdetail['customer_name'] = $orderDatamodel1->getData('customer_firstname').' '.$orderDatamodel1->getData('customer_lastname');
						$orderdetail['product_details'] = $product_information;
						$orderdetail['payment_method'] = $orderDatamodel1->getPayment()->getMethodInstance()->getTitle();
						$orderdetail['shipping_method'] = $orderDatamodel1->getData('shipping_method');
						$orderdetail['cust_id'] = $orderDatamodel1->getData('customer_id');
						$orderdetail['subtotal'] = $orderDatamodel1->getData('subtotal');
						$orderdetail['shipping_amount'] = $orderDatamodel1->getData('shipping_amount');
						$orderdetail['grand_total'] = $orderDatamodel1->getData('grand_total');
						$orderdetail['total_qty'] = $orderDatamodel1->getData('total_qty_ordered');
						$orderdetail['currency'] = $orderDatamodel1->getData('store_currency_code');
						$orderdetail['status'] = $orderDatamodel1->getData('status');
						
						$orderresult[] = $orderdetail;
					}
					
					//print_r($orderresult);
				   $response = json_encode($orderresult);
				   echo $response;
				die;

				} 
			   else {
		           $orderresult = "There is No Data";
				   $response = json_encode($orderresult);
				  
		       echo $response;
			   die;
		   
		   }
			   
		   } 
		   
		/*   } 
	else { 
		   
		    echo "customer is not Valid please check userdata";
			die;
		   
		   
		   } */
	
    }
			
		
	
}

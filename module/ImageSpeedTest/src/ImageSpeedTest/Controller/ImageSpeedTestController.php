<?php 


namespace ImageSpeedTest\Controller;


use
    ImageSpeedTest\Form\ImageSpeedTestUploadForm,
    ImageSpeedTest\Entity\ImageSpeedTest,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;



/**
 * @author wiltshirek
 *
 */
class ImageSpeedTestController extends AbstractActionController

{
	
	
	/**
	 * @return multitype:\ImageSpeedTest\Form\ImageSpeedTestUploadForm 
	 * dummy function to supply a valid form to page for future enhancements
	 * returns an empty form but valid form
	 */
	public function uploadAction(){
		$form = new ImageSpeedTestUploadForm('upload-form');
		//var_dump(filter_var('example.com', FILTER_VALIDATE_URL));
		return array('form' => $form);	
		
	}
	
	/**
	 * @return \Zend\View\Model\ViewModel|multitype:\ImageSpeedTest\Form\ImageSpeedTestUploadForm
	 * loads array with stats based on image load time 
	 */
	public function testurlAction()
	{
		$form = new ImageSpeedTestUploadForm('upload-form');
		$request = $this->getRequest();
		if ($request->isPost()) {

			$entity = new ImageSpeedTest();
			$post = $request->getPost();
			$form->setData($post);
			if ($form->isValid()) {
				$entity->populate($form->getData());
				$url = $entity->__get('url');
				//lets make sure we have a valid url
				
				//retrieve and send the variables to the view model
				$view = new ViewModel(array(
						'imgInfo' => $this->getImageInfo($url)));
				return $view;
			}
		}
	
		return array('form' => $form);
	}
/**
 * 
 * @param String $url
 * @return multitype:number Ambigous <number, unknown> multitype:number unknown
 * 
 * Travers DOM for img elements.  Record load time.  Pass array of info to view
 * Considerations:  Array is loaded using a simple key structure.  Although view page
 * will probably display image urls before results we provide explicit keys so items can
 * be accessed directly in any order.  Also minimizes the amount of logic required in the view file.
 */
	
private function getImageInfo($url){
	
	$dom = new \DOMDocument();
	//load dom from url and surpress warnings
	@$dom->loadHTMLFile($url);
	
	$imgElements = $dom->getElementsByTagName('img');
	$imgLoadInfo = array();
	$totalImgLoadTime = 0;
	$worstImgLoadTime = 0;
	$i=0;
	foreach ($imgElements as $img) {
			$imgUrl = $img->getAttribute('src');
			
			//fetch image to local variable and start timer
			$startTime = $this->getStartTime();
			$content = @file_get_contents($imgUrl);			  			
			$elapsedTime = $this->getElapsedTime($startTime);
			//store properties for viewModel
			$imgProperties[] =  array(
                    'url'    => $imgUrl,
                    'loadTime' => $elapsedTime,
                    );
                 
			$totalImgLoadTime = $totalImgLoadTime + $elapsedTime;
			$worstImgLoadTime = ($elapsedTime>$worstImgLoadTime ? $elapsedTime:$worstImgLoadTime);
			
		}
		$avgLoadTime=$totalImgLoadTime / $imgElements->length;	
		$imgLoadInfo['totalImgLoadTime'] =  $totalImgLoadTime;
		$imgLoadInfo['avgLoadTime'] = $avgLoadTime;
		$imgLoadInfo['imgProperties'] = $imgProperties;
		$imgLoadInfo['worstImgLoadTime'] = $worstImgLoadTime;
		return $imgLoadInfo;
		
	}
	
	
	


	/**
	 * @return number
	 */
	private function getStartTime(){
		
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		return $time;
		
	}
	
	/**
	 * @param number in microtime $start
	 * @return number
	 */
	private function getElapsedTime($start){
		
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		return $total_time;
	}
	
	
	public function validateformAction(){
	
		//$this->_helper->layout()->disableLayout();
		//$this->_helper->viewRenderer->setNoRender(true);
		$request = $this->getRequest();
		$f =  new ImageSpeedTestUploadForm();
		$entity = new ImageSpeedTest();
	
		$f->setInputFilter($entity->getInputFilter());
		$f->setData($request->getPost());
		$f->isValid();
		$json = $f->getMessages();
		header('Content-type: application/json');
		echo \Zend\Json\Json::encode($json);
		exit;
		
	
	}

}
	

		
	
	
	
	
	


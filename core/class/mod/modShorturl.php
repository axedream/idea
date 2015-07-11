<?php
class Shorturl extends Singleton{

    public $input;              //mass input data
    public $output;             //mass output data
	public $ip;			        //ip adreess of thit user
	public $request;	        //request from database
	public $table= "xiag_sl";   //base table url

	//$this->url_code = base_convert($this->url,10, 36);

	public function __construct() {
		$this->ip = $_SERVER["REMOTE_ADDR"];
    	}


    public function getUrl($gen) {
        //validate param gen
        if (preg_match(Router::gi()->regExp['short_ulr'], $gen)) {
            $this->request['gen']['count'] = "SELECT COUNT(*) AS CC FROM $this->table WHERE gen = '".substr($gen,1)."'";
    		MySQLDB::gi()->inputQuery = $this->request['gen']['count'];
            MySQLDB::gi()->getDBData();
            MySQLDB::gi()->inputQuery;
		    if (MySQLDB::gi()->DataDB['data']['0']['CC']!="0") {
                $this->request['gen']['data'] 	= "SELECT * FROM $this->table WHERE gen = '".substr($gen,1)."'";
        		MySQLDB::gi()->inputQuery = $this->request['gen']['data'];
                MySQLDB::gi()->getDBData();
                MySQLDB::gi()->inputQuery;
				$this->output['type']       =   'dataOutput_real' ;
				$this->output['message']    =   MySQLDB::gi()->DataDB['data']['0']['real'];
                $this->output['error']      =   'no';
                }
            else {
                $this->output['type']       =   'checkGetUrlLink';
    			$this->output['message']    =   'We regret, but this link isn\'t present in our base. You can add again.';
                $this->output['error']      =   'yes';
                }
            }
        //not valide url
        else {
            $this->output['type']       =   'checkValidUrl';
			$this->output['message']    =   'You url no valid from this service.';
            $this->output['error']      =   'yes';
            }
        }//end getUrl

	public function setUrl ($url) {
	    if ( $this->checkUrl($url) ) {
            $this->setVar();
            if ( $this->checkHesh() ) {
                $this->output['type']       =   'dataOutput_hesh';
                $this->output['message']    =   'This URL was already earlier generated';
                $this->output['error']      =   'no';
                }
            else {
                if ($this->checkDateIp()) {
                    $this->output['type']       =   'checkDateIp';
                    $this->output['message']    =   'You too often try to generate the link. Admissible interval 2 minutes! Wait 2 minutes and try again.';
                    $this->output['error']      =   'yes';
                    $this->output['url']        =   '-';
                    } //need make function -> error (in the future)
                else {
                	//step for gen
                	$lastGEN = $this->getLastGen()+1;
                	//return $lastGEN;
                    $gen = base_convert($lastGEN,10, 36);

                    MySQLDB::gi()->inputTable = $this->table;
                    MySQLDB::gi()->inputData = [
                        'hesh'  => md5($this->url),
                        'gen'   => $gen,
                        'real'  => $this->url,
                        'dip'   => $this->ip
                        ];
                    MySQLDB::gi()->insertDBData();

                	$this->output['type']       =   'dataOutput_gen' ;
                	$this->output['message']    =   'This ShortURL is successfully generated' ;
                    $this->output['error']      =   'no';
                    $this->output['url']        =   $gen;
                	}
                }//end checkHesh
            }//end checkURL
        else {
            $this->output['type']       =   'checkUrl' ;
            $this->output['message']    =   'Not the correct address of a link is entered. Change an adrsa and repeat generation procedure.';
            $this->output['error']      =   'yes';
            $this->output['url']        =   '-';
            }

        return $this->output;
		}//end setUrl


	private function setVar() {
        //mass for request database
        $this->request = [
                'count'     =>  [
                        'hesh'              =>  "SELECT COUNT(*) AS CC FROM $this->table WHERE hesh = '".md5($this->input['url'])."'",
                        'lastDataLine'      =>  "SELECT COUNT(*) AS CC from $this->table where id = (select max(id) from $this->table)",
                        'ip'                =>  "SELECT COUNT(*) AS CC FROM $this->table WHERE dip = '".$this->ip."' AND TO_SECONDS(NOW()) - TO_SECONDS(dcreate) <= 120 "
                    ],
                'data'      =>  [
                        'hesh'              =>  "SELECT * FROM $this->table WHERE hesh = '".md5($this->input['url'])."'",
                        'lastDataLine'      =>  "select * from $this->table where id = (select max(id) from $this->table)"
                ]
            ];

 	}//end setVar

	//return last GEN (from 10000)
	function getLastGen() {
		MySQLDB::gi()->getDBData($this->request['count']['lastDataLine']);
		if (MySQLDB::gi()->DataDB['data']['0']['CC']=="0") return "10000";
		else{
            MySQLDB::gi()->getDBData($this->request['data']['lastDataLine']);
            return base_convert(MySQLDB::gi()->DataDB['data']['0']['gen'],36, 10);
            }
		}//end getLastGen

    //chekin URL
    public function checkUrl($url) {
        if ( !preg_match(App::gi()->config['regexp']['uri']['full_url'], trim($url)) ) return FALSE;
        else {
            $this->input['url'] = trim($url);
            return TRUE;
            }
        }//end checkUrl

	//return FALSE if not found hesh, TRUE if found and set $this->url['output'] fouded url
    public function checkHesh() {
        MySQLDB::gi()->getDBData($this->request['count']['hesh']);
		if (MySQLDB::gi()->DataDB['data']['0']['CC']!="0") {
            MySQLDB::gi()->getDBData($this->request['data']['hesh']);
			$this->output['url'] = MySQLDB::gi()->DataDB['data']['0']['gen'];
			return TRUE;
			}//end count hesh
		else return FALSE;
		}//end checkData

	//retrun -> FALSE if not found row, -> TRUE  if found
	public function checkDateIp() {
        MySQLDB::gi()->getDBData($this->request['count']['ip']);
		if (MySQLDB::gi()->DataDB['data']['0']['CC']!="0") return TRUE;
		else return FALSE;
		}

	//feature unit test
	function unitTest() {
		echo "test is successfuled";
		}
	
}
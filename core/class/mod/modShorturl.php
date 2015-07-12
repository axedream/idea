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
        $this->config = App::gi()->config['message']['shorturl'];
    	}


    public function getUrl($url) {
        if ( $this->checkUrl($url) ) {
            $this->setVar();
            MySQLDB::gi()->getDBData($this->request['count']['gen']);
		    if (MySQLDB::gi()->DataDB['data']['0']['CC']!="0") {
                MySQLDB::gi()->getDBData($this->request['data']['gen']);
				$this->output['type']       =   'dataOutput_real' ;
                $this->output['message']    =   $this->config['dataOutput_real'];
				$this->output['gen']        =   MySQLDB::gi()->DataDB['data']['0']['real'];
                $this->output['error']      =   'no';
                }
            else {
                $this->output['type']       =   'checkGetUrlLink';
    			$this->output['message']    =   $this->config['checkGetUrlLink'];
                $this->output['error']      =   'yes';
                $this->output['gen']        =   '-';
                }
            }
        //not valide url
        else {
            $this->output['type']       =   'checkValidUrl';
			$this->output['message']    =   $this->config['checkValidUrl'];
            $this->output['error']      =   'yes';
            $this->output['gen']        =   '-';
            }
        }//end getUrl

	public function setUrl ($url) {
	    if ( $this->checkUrl($url) ) {
            $this->setVar();
            if ( $this->checkHesh() ) {
                $this->output['type']       =   'dataOutput_hesh';
                $this->output['message']    =   $this->config['dataOutput_hesh'];
                $this->output['error']      =   'no';
                }
            else {
                if ($this->checkDateIp()) {
                    $this->output['type']       =   'checkDateIp';
                    $this->output['message']    =   $this->config['checkDateIp'];
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
                        'hesh'  => md5($this->input['url']),
                        'gen'   => $gen,
                        'real'  => $this->input['url'],
                        'dip'   => $this->ip
                        ];
                    MySQLDB::gi()->insertDBData();

                	$this->output['type']       =   'dataOutput_gen' ;
                	$this->output['message']    =   $this->config['dataOutput_gen'];
                    $this->output['error']      =   'no';
                    $this->output['url']        =   $gen;
                	}
                }//end checkHesh
            }//end checkURL
        else {
            $this->output['type']       =   'checkUrl' ;
            $this->output['message']    =   $this->config['checkUrl'];
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
                        'ip'                =>  "SELECT COUNT(*) AS CC FROM $this->table WHERE dip = '".$this->ip."' AND TO_SECONDS(NOW()) - TO_SECONDS(dcreate) <= 120 ",
                        'gen'               =>  "SELECT COUNT(*) AS CC FROM $this->table WHERE gen = '".substr($this->input['url'],1)."'"
                    ],
                'data'      =>  [
                        'hesh'              =>  "SELECT * FROM $this->table WHERE hesh = '".md5($this->input['url'])."'",
                        'lastDataLine'      =>  "select * from $this->table where id = (select max(id) from $this->table)",
                        'gen'               =>  "SELECT * FROM $this->table WHERE gen = '".substr($this->input['url'],1)."'"
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
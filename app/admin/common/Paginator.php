<?php


namespace app\admin\common;


class Paginator {
    protected $number;// 每页显示量
    protected $totalCount; // 总数据量
    protected $totalPage; //总页数
    protected $page; //当前页
    protected $url; //当前url
    protected $maxPage; // 最大显示页码

    public function __construct($totalCount,$number=5,$maxPage=10) {
        $this->number=$number;
        $this->totalCount=$totalCount;
        $this->totalPage=$this->getTotalPage();
        $this->page = $this->getPage();
        $this->url = $this->getUrl();
        $this->maxPage = $maxPage;
    }

    /**
     *总页数
     */
    protected function getTotalPage(){
//        dd($this->number);
        return ceil($this->totalCount/$this->number);

    }

    /**
     *当前页
     */
    protected function getPage(){
        if(empty($_GET['page'])){
            $page = 1;
        }elseif ($_GET['page']>$this->totalPage){
            $page = $this->totalPage;
        }elseif ($_GET['page']<1){
            $page = 1;
        }else{
            $page=$_GET['page'];
        }
        return $page;
    }

    /**
     *每页显示量
     */
    protected function getNumber(){
        return $this->number;
    }

    /**
     *当前url
     */
    protected function getUrl(){
        $scheme = $_SERVER['REQUEST_SCHEME']; // 当前url协议
        $host = $_SERVER['SERVER_NAME']; // 当前url主机名
        $port = $_SERVER['SERVER_PORT']; //当前url端口
        $uri = $_SERVER['REQUEST_URI']; // 当前url除协议、主机名、端口以外的

        $uriArr = parse_url($uri); //解析一个uri
        $path = $uriArr['path']; // 得到文件路径
        if(!empty($uriArr['query'])){
            parse_str($uriArr,$arr); // 将请求字符串转为数组
            unset($arr['page']); // 清除数组中的page键和值
            $query = http_build_query($arr); //将清除page后的数组转为字符串
            if(''!=$query){
                $path = $path.'?'.$query;
            }
        }
        return $scheme.'://'.$host.':'.$port.$path;  //返回一个当前url

    }

    /**
     *输出分页
     * @param
     * @return array
     */
    public function allUrl(){
        return [
            'first' =>$this->first(),
            'next' =>$this->next(),
            'prev' => $this->prev(),
            'end' => $this->end(),
            'active' => $this->getPage(),
            'max_page' => $this->totalPage,
            'page' => $this->page(),
        ];
    }

    /**
     *设置当前页的url
     * @param string
     * @return string
     */
    public function setUrl($str){
        if(strstr($this->url,'?')){
            $url = $this->url.'&'.$str;
        }else{
            $url = $this->url.'?'.$str;
        }
        return $url;
    }

    /**
     *首页
     * @return string
     */
    public function first(){
        return $this->setUrl('page=1');
    }

    /**
     *下一页
     * @return string
     */
    public function next() {
        if ($this->page + 1 > $this->totalPage) {
            $page = $this->totalPage;
        } else {
            $page = $this->page + 1;
        }
        return $this->setUrl('page=' . $page);
    }

    /**
     *上一页
     * @return string
     */
    public function prev() {
        if ($this->page - 1 < 1) {
            $page = 1;
        } else {
            $page = $this->page - 1;
        }
        return $this->setUrl('page=' . $page);
    }

    /**
     *最后一页
     * @return string
     */
    public function end() {
        return $this->setUrl('page=' . $this->totalPage);
    }

    /**
     *页码
     * @return string
     */
    public function page() {

        $page = [];
        for ($i = 1; $i <= $this->totalPage; $i++) {
            $page[$i]['value'] = $this->setUrl('page=' . $i);
            $page[$i]['label'] = $i;
        }
        if (count($page) > $this->maxPage) {
            $zPage = floor($this->maxPage / 2); //中页码
            $activePage = $this->getPage();
            if ($activePage > $zPage && $activePage + $zPage<= $this->totalPage) {
                $page = array_slice($page, $activePage - 1 - $zPage, $this->maxPage);
            } else {
                $offset = $activePage <= $zPage ? 0 : $this->totalPage - $this->maxPage;
                $page = array_slice($page, $offset, $this->maxPage);
            }
        }
        return $page;
    }

    /**
     *每页偏移量
     * @return int
     */
    public function limit() {
        return ($this->page - 1) * $this->number;
    }

}
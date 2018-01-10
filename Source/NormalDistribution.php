<?php
/**
 * Created by PhpStorm.
 * User: severus
 * Date: 2018/1/10
 * Time: 下午9:58
 */

class NormalDistribution {
    //原始数据
    public $list = array();

    //最大值
    public $maximaValue;
    //最小值
    public $minimumValue;
    //极差
    public $maximumDistance;
    //数据算术平均
    public $meanValue;
    //数据的标准方差
    public $standard_dev;
    //概率密度函数
    public $cumulative = 0;

    //分组数
    public $groupNumber;
    //分组组距
    public $groupDistance;
    //分组列表
    public $groupArray = array();

    //频率
    public $frequencyArray;
    //正态分布图点位
    public $normalDistributionPointArray = array();


    /**
     * NormalDistribution constructor.
     * @param $list array 原始数据
     */
    public function __construct($list) {
        $this->list = $list;
        //最大值  =MAX(A:A)
        $this->maximaValue = max($this->list);
        //最小值  =MIN(A:A)
        $this->minimumValue = min($this->list);
        //极差  =C1-C2
        $this->maximumDistance = $this->maximaValue - $this->minimumValue;
        //数据算术平均  =AVERAGE(A:A)
        $this->meanValue = array_sum($list) / count($list);
        //数据的标准方差  =STDEV(A:A)
        $this->standard_dev = $this->getSigma($this->list);

        //计算分组信息
        $this->calculateGroupInfo();

        //统计频率
        $this->statisticsFrequency();

        //统计正态分布图点位
        $this->statisticsNormalDistributionPoint();
    }


    /**
     * 计算分组信息
     */
    public function calculateGroupInfo() {
        //分组数量  =ROUNDUP ( SQRT(COUNT(A:A)) ,0)
        $this->groupNumber = $this->ROUNDUP(sqrt(count($this->list)));
        //分组组距  =C3/C4
        $this->groupDistance = $this->maximumDistance / $this->groupNumber;
        //分组列表
        $this->groupArray [] = $this->minimumValue - 0.1;
        while ($this->maximaValue > end($this->groupArray))
            $this->groupArray[] = end($this->groupArray) + $this->groupDistance;
    }


    /**
     * 统计频率
     * 实现 Excel FREQUENCY 函数
     */
    public function statisticsFrequency() {
        foreach ($this->groupArray AS $key => $value) {
            $itemNum = 0;
            foreach ($this->list AS $item) {
                if ($key == 0) { //第一个组
                    if ($value > $item)
                        $itemNum += 1;
                    continue;
                } else if ($key == count($this->groupArray) - 1) { //最后一个组
                    if ($this->groupArray[$key - 1] < $item)
                        $itemNum += 1;
                    continue;
                } else { //中间组
                    if (($item > $this->groupArray[$key - 1]) && $item < $value)
                        $itemNum += 1;
                    continue;
                }
            }
            $this->frequencyArray[(string)$value] = $itemNum;
        }
    }


    /**
     * 统计正态分布图点位
     */
    public function statisticsNormalDistributionPoint() {
        foreach ($this->groupArray AS $groupItem)
            $this->normalDistributionPointArray[] = PHPExcel_Calculation_Statistical::NORMDIST($groupItem, $this->meanValue, $this->standard_dev, $this->cumulative);
    }


    /**
     * 实现 Excel ROUNDUP 函数
     * @param $input
     * @return int
     */
    public function ROUNDUP($input) {
        return ((int)$input == $input) ? (int)$input : (int)$input + 1;
    }


    /**
     * @name 获取标准差
     * @param array $list
     * @return number
     * @beizhu 标准差  = 方差的平方根
     */
    private function getSigma($list) {
        $total_var = 0;
        foreach ($list as $v) {
            $total_var += pow(($v - $this->meanValue), 2);
        }

        return sqrt($total_var / (count($list) - 1)); // 这里为什么数组元素个数要减去1
    }

}
<?php
namespace Concrete\Package\DynamicImages\Block\DynamicImages;

use Concrete\Core\Block\BlockController;
use Database;

class Controller extends BlockController
{
    protected $btTable = 'btDynamicImages';
    protected $btInterfaceWidth = "992";
    protected $btInterfaceHeight = "650";
    protected $btWrapperClass = "ccm-ui";
    protected $btIgnorePageThemeGridFrameworkContainer = true;
    protected $btDefaultSet = 'multimedia';

    public function getBlockTypeName()
    {
        return t('Dynamic Images');
    }

    public function getBlockTypeDescription()
    {
        return t('Repeatable Dynamic Images Starter Block');
    }

    public function add()
    {
        $this->requireAsset('core/file-manager');

        if(!$this->displayTitle) {
            $displayTitle = 1;
        }
        $this->set('displayTitle', $displayTitle);

        if(!$this->enableImage) {
            $enableImage = 1;
        }
        $this->set('enableImage', $enableImage);

        $this->requireAsset('dynamic_images_form');
    }

    public function edit()
    {
        $this->requireAsset('core/file-manager');
        $db = Database::connection();
        $q = 'SELECT * from btRepeatableImage WHERE bID = ? ORDER BY sortOrder';
        $query = $db->fetchAll($q, array($this->bID));
        $this->set('items', $query);
        $this->requireAsset('dynamic_images_form');

    }

    public function view()
    {
        $this->set('items', $this->getEntries());
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btRepeatableImage', array('bID' => $this->bID));
        parent::delete();
    }

    public function getEntries()
    {
        $db = Database::connection();
        $q = 'SELECT * from btRepeatableImage WHERE bID = ? ORDER BY sortOrder';
        $rows = $db->fetchAll($q, array($this->bID));
        $items = array();
        foreach ($rows as $row) {
            $items[] = $row;
        }

        return $items;
    }

    public function save($data)
    {
        $data['displayTitle'] = intval($data['displayTitle']);
        $data['enableImage'] = intval($data['enableImage']);
        $data['cropImage'] = intval($data['cropImage']);
        $data['crop'] = intval($data['crop']);
        $db = Database::connection();
        $q = 'DELETE from btRepeatableImage WHERE bID = ?';
        $db->executeQuery($q, array($this->bID));
        parent::save($data);
        if (isset($data['sortOrder'])) {
            $count = count($data['sortOrder']);
            $i = 0;

            while ($i < $count) {
                $q = 'INSERT INTO btRepeatableImage (bID, fID, title, customElementClass, sortOrder) values(?,?,?,?,?)';
                $db->executeQuery($q,
                    array(
                        $this->bID,
                        intval($data['fID'][$i]),
                        $data['title'][$i],
                        $data['customElementClass'][$i],
                        $data['sortOrder'][$i],
                    )
                );
                ++$i;
            }
        }
    }
}

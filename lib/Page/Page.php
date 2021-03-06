<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Page;

use PHPoole\Collection\AbstractItem;
use Symfony\Component\Finder\SplFileInfo;
use Cocur\Slugify\Slugify;

/**
 * Class Page
 * @package PHPoole\Page
 */
class Page extends AbstractItem implements \ArrayAccess
{
    use PageVariablesTrait;

    const SLUGIFY_PATTERN = '/([^a-z0-9\/]|-)+/';

    /**
     * @var SplFileInfo
     */
    protected $file;
    /**
     * @var string
     */
    protected $fileExtension;
    /**
     * @var string
     */
    protected $filePath;
    /**
     * @var string
     */
    protected $fileId;
    /**
     * @var bool
     */
    protected $virtual = false;
    /**
     * @var string
     *
     * 'homepage', 'list' or 'page'
     */
    protected $nodeType = 'page';

    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $pathname;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $title = 'Default title';
    /**
     * @var string
     */
    protected $section;
    /**
     * @var string
     */
    protected $layout;

    /**
     * @var string
     */
    protected $frontmatter;
    /**
     * @var string
     */
    protected $body;
    /**
     * @var string
     */
    protected $html;

    /**
     * Constructor
     *
     * @param null|SplFileInfo $file
     */
    public function __construct(SplFileInfo $file = null)
    {
        $this->file = $file;

        if ($this->file instanceof SplFileInfo) {
            // file extension : md
            $this->fileExtension = pathinfo($this->file, PATHINFO_EXTENSION);
            // file path : Blog
            $this->filePath      = str_replace(DIRECTORY_SEPARATOR, '/', $this->file->getRelativePath());
            // file id : Blog/Post 1
            $this->fileId        = ($this->filePath ? $this->filePath . '/' : '') . basename($this->file->getBasename(), '.' . $this->fileExtension);
            // id : blog/post-1
            $this->id            = $this->urlize($this->fileId);
            // pathname : blog/post-1
            $this->pathname      = $this->urlize($this->fileId);
            // path : blog
            $this->path          = $this->urlize($this->filePath);
            // name : post-1
            $this->name          = $this->urlize(basename($this->file->getBasename(), '.' . $this->fileExtension));
            /**
             * frontmatter default values
             */
            // title : Post 1
            $this->title   = basename($this->file->getBasename(), '.' . $this->fileExtension);
            // section : blog
            $this->section = explode('/', $this->path)[0];
        } else {
            $this->virtual = true;
        }
    }

    /**
     * Format string into URL
     *
     * @param $string
     * @return string
     */
    public static function urlize($string)
    {
        return Slugify::create(self::SLUGIFY_PATTERN)->slugify($string);
    }

    /**
     * Is current page is virtual?
     *
     * @return bool
     */
    public function isVirtual() {
        return $this->virtual;
    }

    /**
     * Set node type
     *
     * @param $nodeType
     * @return self
     * @throws \Exception
     */
    public function setNodeType($nodeType) {
        $this->nodeType = $nodeType;
        return $this;
    }

    /**
     * Get node type
     *
     * @return string
     */
    public function getNodeType() {
        return $this->nodeType;
    }

    /**
     * Parse file content
     *
     * @return $this
     */
    public function parse()
    {
        $parser = new Parser($this->file);
        $parsed = $parser->parse();
        $this->frontmatter = $parsed->getFrontmatter();
        $this->body        = $parsed->getBody();
        return $this;
    }

    /**
     * Set name
     *
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path name
     *
     * @param $pathname
     * @return $this
     */
    public function setPathname($pathname)
    {
        $this->pathname = $pathname;
        return $this;
    }

    /**
     * Get path name
     *
     * @return string
     */
    public function getPathname()
    {
        return $this->pathname;
    }

    /**
     * Set section
     *
     * @param $section
     * @return $this
     */
    public function setSection($section)
    {
        $this->section = $section;
        return $this;
    }

    /**
     * Get section
     *
     * @return string
     */
    public function getSection()
    {
        if (empty($this->section) && !empty($this->path)) {
            $this->section = explode('/', $this->path)[0];
        }
        return $this->section;
    }

    /**
     * Set title
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set ID
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get frontmatter
     *
     * @return string
     */
    public function getFrontmatter()
    {
        return $this->frontmatter;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set HTML
     *
     * @param $html
     * @return $this
     */
    public function setHtml($html)
    {
        $this->html = $html;
        return $this;
    }

    /**
     * Get HTML alias
     *
     * @return string
     */
    public function getContent()
    {
        return $this->html;
    }

    /**
     * Set layout
     *
     * @param $layout
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Get layout
     *
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }
}
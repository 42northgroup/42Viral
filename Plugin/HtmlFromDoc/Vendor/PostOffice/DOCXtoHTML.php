<?php

/** CLASS DOCXtoHTML Premium will convert a .docx file to (x)html.
 *
 * This class uses the dUnzip2 class from phpclasses.org and requires extension ZLib
 * This class can only handle 1 single file per instance.
 * This class might overrun the execution time limit.
 *
 * Variables that can be set:
 * @see *$docxPath
 * @see $paragraphs
 * @see *$image_max_width
 * @see $mediaDir
 * @see $imagePathPrefix
 *
 * Variables Returned by Class:
 * @see $status
 * @see $output
 * @see $error
 * @see $time
 */

class DOCXtoHTML
{

    /**
     * @var String This is the path to the file that should be read
     * @since 1.0
     */
    public $docxPath = "";

    /**
     * @var String This is where the ziped contents will be extracted to to process
     * @since 1.0
     */
    public $tempDir = "";

    /**
     *
     * @var String This is the html data that is returned from this class
     * @since 1.0
     */
    public $output = array();

    /**
     *
     * @var Bool Should colored text be allowed or not
     * @since 1.0
     */
    public $allowColor = false;

    /**
     * @var Int This is the maximum width of an image after the process
     * @since 1.0
     * @update 1.2
     */
    public $image_max_width = 0;

    /**
     * @var String The path to where the content is extracted
     * @since 1.0
     */
    public $content_folder = "";

    /**
     * @var String The current Status of the class
     * @since 1.0
     */
    public $status = "";

    /**
     * @var String The path to where the media files of the document should be extracted
     * @since 1.0
     */
    public $mediaDir = "";

    /**
     * @var String The value of this variable will be prefixed to the path of the image. This class will create a folder
     * 2 levels up, inside an 'upload' folder and this value should go to there.
     * @since 1.0
     */
    public $imagePathPrefix = "";

    /**
     * @var Array This contains the relationships of different elements inside the word document and is used to link to
     * the correct image.
     * @since 1.1
     */
    public $rels = array();

    /**
     * @val String The error number generated and the meaning of the error
     * @since 1.0
     */
    public $error = NULL;

    /**
     * @val String This will contain the closing tag of a paragraph level opened tag that can't be specified explicitly
     * @since 1.1
     */
    public $tagclosep = "";

    /**
     * @val String This will contain the closing tag of a text opened tag that can't be specified explicitly
     * @since 1.1
     */
    public $tagcloset = "";

    /**
     * @val Bool Should a thumbnail be created as well as to keep the original image in the folder
     * @since 1.3
     */
    public $keepOriginalImage = false;

    /**
     * @var boolean Should images be included in the HTML output or not
     */
    public $doImages = false;

    /**
     * @val Bool Split the document into multiple posts/pages
     * @since 1.3
     */
    public $split = false;

    /**
     * This function will set the status to Ready when the class is called. The Constructor Method.
     * @return Bool True when ready
     * @since 1.0
     */
    public function __construct()
    {
        $this->status = "Ready";
        return true;
    }

    /**
     * This function call the Constructor Method
     * @return Bool True when ready
     * @since 1.0
     */
    public function DOCXtoHTML()
    {
        return __construct();
    }

    /**
     * This function will initialize the process as well as handle the process automatically.
     * This requires that the vars be set to start
     * @return Bool True when successfully completed
     * @since 1.0
     * @modified 1.2.3
     */
    public function Init($PostOffice)
    {
        //global $PostOffice;

        if ($this->extractRelXML() == false) {
            $this->DeleteTemps();
            $PostOffice->__destruct();
            $this->error = "12. The file data could not be found or read.";
            return false;
        }
        if ($this->doImages && $this->extractMedia() == false) {
            $this->DeleteTemps();
            $PostOffice->__destruct();
            $this->error = "13. The Media could not be found.";
            return false;
        }
        if ($this->extractXML() == false) {
            $this->DeleteTemps();
            $PostOffice->__destruct();
            $this->error = "14. The file data could not be found or read.";
            return false;
        }
        if ($this->DeleteTemps() == false) {
            $PostOffice->__destruct();
            $this->error = "15. The temporary files created during the process could not be deleted.
                The contents, however, might still have been extracted.";
            return false;
        }
        return true;
    }

    /**
     * This function handles the extraction of the XML building the Rels array
     * @return Bool True on success
     * @since 1.1
     * @modified 1.2.3
     */
    public function extractRelXML()
    {
        $xmlFile = $this->tempDir . "/word/_rels/document.xml.rels";
        if (is_file($xmlFile)) {
            $xml = file_get_contents($xmlFile);
        } else {
            echo "the file " . $xmlFile . " could not be found<br /><br />";
            return false;
        }
        if ($xml == false) {
            return false;
        }
        $xml = mb_convert_encoding($xml, 'UTF-8', mb_detect_encoding($xml));
        $parser = xml_parser_create('UTF-8');
        $data = array();
        xml_parse_into_struct($parser, $xml, $data);
        foreach ($data as $value) {
            if ($value['tag'] == "RELATIONSHIP") {
                //it is an relationship tag, get the ID attr as well as the TARGET and (if set, the targetmode)set into
                //var.
                if (isset($value['attributes']['TARGETMODE'])) {
                    $this->rels[$value['attributes']['ID']] = array(
                        0 => $value['attributes']['TARGET'],
                        3 => $value['attributes']['TARGETMODE']
                    );
                } else {
                    $this->rels[$value['attributes']['ID']] = array(
                        0 => $value['attributes']['TARGET']
                    );
                }
            }
        }
        return true;
    }

    /**
     * This function handles the extraction of the Media
     * @return Bool True on success
     * @since 1.1
     * @modified 1.2.3
     */
    public function extractMedia()
    {
        $wordFolder = $this->tempDir . "/word/";
        if (!is_dir($wordFolder . "media")) {
            return true;
            //there are no images to extract
        }
        $this->getMediaFolder();
        $i = false;
        
        foreach ($this->rels as $key => $value) {
            if (
                strtolower(pathinfo($value[0], PATHINFO_EXTENSION)) == "png" ||
                strtolower(pathinfo($value[0], PATHINFO_EXTENSION)) == "gif" ||
                strtolower(pathinfo($value[0], PATHINFO_EXTENSION)) == "jpg" ||
                strtolower(pathinfo($value[0], PATHINFO_EXTENSION)) == "jpeg"
            ) {
                //this really is an image that we are working with
                $fileType = strtolower(pathinfo($value[0], PATHINFO_EXTENSION));
                //set the file type so that the correct image creation function can be called
                if (is_file($wordFolder . $value[0])) {
                    if ($this->keepOriginalImage == true) {
                        $image = $this->processImage($wordFolder . $value[0], $this->image_max_width);
                        $imageorr = $this->processImage($wordFolder . $value[0]);
                        /* if( imageSx( $imageorr ) == $this->image_max_width ){
                          //they are the extact same width, so it is not needed to create it again
                          imageDestroy ( $imageorr );
                          $imageorr = false;
                          } */
                    } else {
                        $image = $this->processImage($wordFolder . $value[0], $this->image_max_width);
                        $imageorr = false;
                    }

                    if ($image) {
                        $i = true; //this have been resourceful, do not return false
                        //the image was successfully created, now write to file
                        $filename = pathinfo($value[0], PATHINFO_BASENAME);
                        if ($fileType == "png") {
                            if (imagePng($image, $this->mediaDir . "/" . $filename, 0, PNG_NO_FILTER)) {
                                imagedestroy($image);
                                $this->rels[$key][1] = $this->webPath . "/" . $filename;
                            }
                        } elseif ($fileType == "gif") {
                            if (imageGif($image, $this->mediaDir . "/" . $filename, 0)) {
                                imagedestroy($image);
                                $this->rels[$key][1] = $this->webPath . "/" . $filename;
                            }
                        } else {
                            if (imageJpeg($image, $this->mediaDir . "/" . $filename, 100)) {
                                imagedestroy($image);
                                $this->rels[$key][1] = $this->webPath . "/" . $filename;
                            }
                        }
                    }

                    if ($imageorr) {
                        $i = true; //this have been resourceful, do not return false
                        //the image was successfully created, now write to file
                        $pathinfo = pathinfo($value[0]);
                        $filename = $pathinfo['filename'] . "_big." . $pathinfo['extension'];
                        if ($fileType == "png") {
                            if (imagePng($imageorr, $this->mediaDir . "/" . $filename, 0, PNG_NO_FILTER)) {
                                imagedestroy($imageorr);
                                $this->rels[$key][2] = $this->webPath . "/" . $filename;
                            }
                        } elseif ($fileType == "gif") {
                            if (imageGif($imageorr, $this->mediaDir . "/" . $filename, 0)) {
                                imagedestroy($imageorr);
                                $this->rels[$key][2] = $this->webPath . "/" . $filename;
                            }
                        } else {
                            if (imageJpeg($imageorr, $this->mediaDir . "/" . $filename, 100)) {
                                imagedestroy($imageorr);
                                $this->rels[$key][2] = $this->webPath . "/" . $filename;
                            }
                        }
                    }
                }
            }
        }

        return $i;
    }

    /**
     * This function creates the folder that will contain the media after the move
     * @return Bool True on success
     * @since 1.0
     */
    public function getMediaFolder()
    {
        if (empty($this->content_folder)) {
            $mediaFolder = pathinfo($this->docxPath, PATHINFO_BASENAME);
            $ext = pathinfo($this->docxPath, PATHINFO_EXTENSION);
            $MediaFolder = strtolower(str_replace("." . $ext, "", str_replace(" ", "-", $mediaFolder)));
            //$this->mediaDir = "../../uploads/media/".$MediaFolder;
            $this->mediaDir = WWW_ROOT . 'files' . DS . 'doc_images/' . DS . $MediaFolder;
            $this->webPath = '/files/doc_images/' . $MediaFolder;
        } else {
            //$this->mediaDir = "../../uploads/media/".$this->content_folder;
            $this->mediaDir = WWW_ROOT . 'files' . DS . 'doc_images' . DS . $this->content_folder;
            $this->webPath = '/files/doc_images/' . $this->content_folder;
        }

        if ($this->mkdir_p($this->mediaDir)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function handles the image proccessing
     * @param String $url Path to the file to proccess
     * @param Int $thumb The maximum width of an proccessed image
     * @return String The binary of the image that was created
     * @since 1.0
     */
    public function processImage($url, $thumb = 0)
    {
        $tmp0 = imageCreateFromString(fread(fopen($url, "rb"), filesize($url)));
        if ($tmp0) {
            if ($thumb == 0) {
                $dim = Array('w' => imageSx($tmp0), 'h' => imageSy($tmp0));
            } else {
                if (imagesx($tmp0) <= $thumb) {
                    if (imageSy($tmp0) > imageSx($tmp0)) {
                        $dim = Array('w' => imageSx($tmp0), 'h' => imageSy($tmp0));
                    } else {
                        $dim = Array('w' => imageSx($tmp0), 'h' => imageSy($tmp0));
                    }
                } else {
                    $dim = Array('w' => $thumb, 'h' => round(imageSy($tmp0) * $thumb / imageSx($tmp0)));
                }
            }
            $tmp1 = imageCreateTrueColor($dim ['w'], $dim ['h']);
            if (imagecopyresized($tmp1, $tmp0, 0, 0, 0, 0, $dim ['w'], $dim ['h'], imageSx($tmp0), imageSy($tmp0))) {
                imageDestroy($tmp0);
                return $tmp1;
            } else {
                imageDestroy($tmp0);
                imageDestroy($tmp1);
                return $this->null;
            }
        } else {
            return $this->null;
        }
    }

    /**
     * This function handles the extraction of the XML file data used to construct the HTML
     * @return Bool True on success
     * @since 1.0
     * @modified 1.2.3
     */
    public function extractXML()
    {
        $xmlFile = $this->tempDir . "/word/document.xml";
        $xml = file_get_contents($xmlFile);
        if ($xml == false) {
            return false;
        }
        $xml = mb_convert_encoding($xml, 'UTF-8', mb_detect_encoding($xml));
        $parser = xml_parser_create('UTF-8');
        $data = array();
        
        xml_parse_into_struct($parser, $xml, $data);
        //echo "<pre>";
        //print_r($data);
        //echo "</pre>";
        $html4output = "";
        $i = 0; //var of post part id
        $h1 = 0; //var of heading 1s done
        
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                switch ($value['tag']) {
                    case "W:P"://the paragrah begins
                        if ($value['type'] == "open") {
                            $html4output .= "<p>";
                        } elseif ($value['type'] == "close") {
                            $html4output .= $this->tagclosep . "</p>";
                            $this->tagclosep = "";
                        }
                        break;

                    case "W:TBL"://the table is initiated
                        if ($value['type'] == "open") {
                            $html4output .= "<table border='1'>";
                        } elseif ($value['type'] == "close") {
                            $html4output .= "</table>";
                        }
                        break;

                    case "W:TR"://the table row is initiated
                        if ($value['type'] == "open") {
                            $html4output .= "<tr>";
                        } elseif ($value['type'] == "close") {
                            $html4output .= "</tr>";
                        }
                        break;

                    case "W:TC"://the table cell is initiated
                        if ($value['type'] == "open") {
                            $html4output .= "<td>";
                        } elseif ($value['type'] == "close") {
                            $html4output .= "</td>";
                        }
                        break;

                    case "W:HYPERLINK"://the hyperlink is initiated
                        if ($value['type'] == "open") {
                            if (array_key_exists('R:ID', $value['attributes'])) {
                                $rid = $value['attributes']['R:ID'];
                                $path = $this->rels[$rid][0];
                                $target = $this->rels[$rid][3];
                            } else {
                                $target = false;
                            }
                            //now determine which type of link it is
                            if (strtolower($target) == "external") {
                                //this is an external link to a website
                                $html4output .= "<a href='" . $path . "'>";
                            } elseif (isset($value['attributes']['W:ANCHOR'])) {
                                $html4output .= "<a href='#" . $value['attributes']['W:ANCHOR'] . "'>";
                            }
                        } elseif ($value['type'] == "close") {
                            $html4output .= "</a>";
                        }
                        break;

                    case "A:BLIP"://the image data
                        if ($this->doImages) {
                            if ($value['type'] == "open" || $value['type'] == "complete") {
                                $rid = $value['attributes']['R:EMBED'];
                                $imagepath = $this->rels[$rid][1];
                                if (array_key_exists(2, $this->rels[$rid])) {
                                    $imagebigpath = $this->rels[$rid][2];
                                } else {
                                    $imagebigpath = false;
                                }

                                if ($this->keepOriginalImage == true && $imagebigpath) {
                                    $html4output .=
                                        "<a href='" . $this->imagePathPrefix . $imagebigpath . "' target='_blank' >" .
                                            "<img style='display:inline;' src='" .
                                                $this->imagePathPrefix . $imagepath . "' alt='' />".
                                        "</a>";
                                } else {
                                    $html4output .= 
                                        "<img style='display:inline;' src='" .
                                            $this->imagePathPrefix . $imagepath . "' alt='' />";
                                }
                            }
                        }
                        break;

                    case "W:T":
                        if ($value['type'] == "complete") {
                            $html4output .= $value['value'] . $this->tagcloset; //return the text (add spaces after)
                            $this->tagcloset = "";
                        }
                        break;

                    case "W:COLOR":
                        if ($value['type'] == "complete" && $this->allowColor) {
                            //add colored text
                            $html4output .= "<span style='color:#" . $value['attributes']['W:VAL'] . ";'>";
                            
                            $this->tagcloset = "</span>";
                        }
                        break;

                    case "V:TEXTPATH":
                        if ($value['type'] == "complete") {
                            if (array_key_exists('STRING', $value['attributes'])) {
                                //add word art text (this is also important)
                                $html4output .= $value['attributes']['STRING']; 
                            }
                        }
                        break;

                    case "W:PSTYLE"://word styles used for headings etc.
                        if ($value['type'] == "complete") {
                            if ($value['attributes']['W:VAL'] == "Heading1") {
                                // -- || Determine if should split or not here || -- //
                                if ($this->split) {
                                    //the document may be split
                                    if ($h1 > 0) {
                                        //it should split if there already have been an heading 1
                                        $this->output[$i] = $html4output;
                                        $i++;
                                        $html4output = "<p>"; //it should start on a paragraph
                                    }
                                }//then just continue an add the H1 tag
                                $html4output .= "<h1>";
                                $h1++;
                                $this->tagclosep = "</h1>";
                            } elseif ($value['attributes']['W:VAL'] == "Heading2") {
                                $html4output .= "<h2>";
                                $this->tagclosep = "</h2>";
                            } elseif ($value['attributes']['W:VAL'] == "Heading3") {
                                $html4output .= "<h3>";
                                $this->tagclosep = "</h3>";
                            }
                        }
                        break;

                    case "W:B"://word style for bold
                        if ($value['type'] == "complete") {
                            if ($this->tagcloset == "</strong>") {
                                break;
                            }
                            $html4output .= "<strong>"; //return the text (add spaces after)
                            $this->tagcloset = "</strong>";
                        }
                        break;

                    case "W:I"://word style for italics
                        if ($value['type'] == "complete") {
                            if ($this->tagcloset == "</em>") {
                                break;
                            }
                            $html4output .= "<em>"; //return the text (add spaces after)
                            $this->tagcloset = "</em>";
                        }
                        break;

                    case "W:U"://word style for underline
                        if ($value['type'] == "complete") {
                            if ($this->tagcloset == "</span>") {
                                break;
                            }

                            //return the text (add spaces after)
                            $html4output .= "<span style='text-decoration:underline;'>"; 
                            $this->tagcloset = "</span>";
                        }
                        break;

                    case "W:STRIKE"://word style for strike-throughs
                        if ($value['type'] == "complete") {
                            if ($this->tagcloset == "</span>") {
                                break;
                            }

                            //return the text (add spaces after)
                            $html4output .= "<span style='text-decoration:line-through;'>"; 
                            $this->tagcloset = "</span>";
                        }
                        break;

                    case "W:VERTALIGN": //word style for super- and subscripts
                        if ($value['type'] == "complete") {
                            if ($value['attributes']['W:VAL'] == "subscript") {
                                $html4output .= "<sub>";
                                $this->tagcloset = "</sub>";
                            } elseif ($value['attributes']['W:VAL'] == "superscript") {
                                $html4output .= "<sup>";
                                $this->tagcloset = "</sup>";
                            }
                        }
                        break;

                    case "W:BOOKMARKSTART": //word style for bookmarks/internal links
                        if ($value['type'] == "complete") {
                            $html4output .= "<a id='" . $value['attributes']['W:NAME'] . "'></a>";
                        }
                        break;

                    default:
                        break;
                }
            }
        }
        $this->output[] = $html4output; //this should output the last part to the output var
        $this->status = "Contents Extracted...";
        if (empty($html4output)) {
            return false;
        }
        return true;
    }

    /**
     * Recursive directory creation based on full path.
     * Will attempt to set permissions on folders.
     * @param string $target Full path to attempt to create.
     * @return bool Whether the path was created or not. True if path already exists.
     * @since 1.0
     */
    public function mkdir_p($target)
    {
        // from php.net/mkdir user contributed notes
        $target = str_replace('//', '/', $target);
        if (file_exists($target)) {
            return @is_dir($target);
        }
        // Attempting to create the directory may clutter up our display.
        if (@mkdir($target)) {
            $stat = @stat(dirname($target));
            $dir_perms = $stat['mode'] & 0007777;  // Get the permission bits.
            @chmod($target, $dir_perms);
            return true;
        } elseif (is_dir(dirname($target))) {
            return false;
        }
        // If the above failed, attempt to create the parent node, then try again.
        if (( $target != '/' ) && ( $this->mkdir_p(dirname($target)) )) {
            return $this->mkdir_p($target);
        }
        return false;
    }

    /**
     * This function concludes the class by removing all te temporary files and folders as well as unsetting all
     * variables not required
     *
     * @return Bool True on success
     * @since 1.0
     */
    public function DeleteTemps()
    {
        //this function will delete all the temp files except the word document
        //(.docx) itself. If this was uploaded it will be removed when the
        //script terminates
        if (is_dir($this->tempDir)) {
            //the temp directory still exist
            $this->rrmdir($this->tempDir);
            unset($this->content_folder);
            unset($this->docxPath);
            unset($this->imagePathPrefix);
            unset($this->image_max_width);
            unset($this->tempDir);
            unset($this->rels);
            unset($this->tagclosep);
            unset($this->tagcloset);
            return true;
        }
        return false;
    }

    /**
     * This function will remove files and directories recursivly
     * @param String $dir The path to the folder to be removed
     */
    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        $this->rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

}

<?

$title_view_all = "";
$titleBigType = "";
switch($_REQUEST ['board']){
	case "group_01_01" : //���ڴ�Ȱ��
		$title_view_all = "AK LOVER ���л� ���ڴ��� Ȱ�� ������ �����ϴ� �����Դϴ�. ����� ��ϰ� ���� ������, �� ���� ������� ã�� �˰ڽ��ϴ�!";
		break;
	case "group_01_02" : 
		$title_view_all = "û��, ��Ź, ����, ��Ÿ ��Ȱ����";
		break;
	case "group_01_03" :  
		$title_view_all = "������, ����, ��Ÿ �丮 ����";
		break;
	case "group_01_04" :  
		$title_view_all = "����, ����, ����, ��Ÿ ��ȭ ����";
		break;
	case "group_02_01" : 
		$title_view_all = "���� �Ϸ� �ϻ��� �����ּ���";
		break;
	case "group_02_03" : //�Ը����̺�Ʈ
		$title_view_all = "�̴��� �̺�Ʈ";
		break;
	case "group_02_02" : //������
			if($_GET["gubun"] == "1") {
				$title_view_all="AK LOVER �������� �ϻ� �� �̾߱⸦ �����Ӱ� �������ּ���.<br/>������ ������ �ִ� ��Ȱ �� �����鵵 �������ֽô� �͵� ���ƿ�!";
			} else if($_GET["gubun"] == "2") {
				$title_view_all="AK LOVER Ȩ���������� ����Ǵ� ü���, �̺�Ʈ ���� ���� �ı� �ۼ� �� �پ��� �ǰ��� �����Ӱ� �������ּ���.";
			} else if($_GET["gubun"] == "3") {
				$title_view_all="�ְ� ��ǰ�� ���� ���� �� ������ ���� �ǰ��� �����Ӱ� �ۼ����ּ���.";
			} else {
				$title_view_all="�������� AK LOVER ȸ���е��� �Ҽ��� �̾߱�, �ϻ� �� ������ ���� ����, ü���, Ȱ�� ���õ� �پ��� �̾߱⸦ �����Ӱ� ������ �����Դϴ�.";
			}
		break;
	case "group_02_05" :  
		$title_view_all = "������, ���ɺ�, �������� �Խñ��� ���� ������������ ������";
		break;
	case "group_03_03" :  //������
		$title_view_all = "������ ������ ���� �����ϴ� �����Դϴ�.";
		break;
	case "group_03_04" : 
		$title_view_all = "��ǰ�� ���� ���̵� �����ּ���";
		break;
	case "group_03_05" :  
		$title_view_all = "��ǰ�� ���� Ī�����ּ���";
		break;
	case "mail" : 
		$title_view_all = "�������Դϴ�";
		break;
	case "group_04_03" : 
		$title_view_all = "AK LOVER�� ���������Դϴ�.";
		break;
	case "group_04_04" :  //�⼮üũ
		$title_view_all = "���� �⼮üũ�ϰ� ����Ʈ 1���� ȹ���ϴ� �����Դϴ�.";
		break;
	case "group_04_05" :  //ü���
		$title_view_all = "�ְ� ��ǰ�� ���� ü���� �� �ִ� �����Դϴ�.";
		break;
	case "group_04_06" :  //��ƼŬ��
		$title_view_all = "���� ���ߵ� Beauty Club ȸ���鸸�� ���� �����Դϴ�.";
		break;
	case "group_04_25" :  //��ƼȦ��
		$title_view_all = "���� ���ߵ� ��ƼȦ�� ȸ���鸸�� ���� �����Դϴ�.";
		break;
	case "group_04_07" :  //�ְ�ڽ�
		$title_view_all = "�ְ� ��ǰ�� ������ ����� ������ ���ϴ� �����Դϴ�.";
		break;
	case "group_04_08" :  //���ڴ�
		$title_view_all = "���� ���ߵ� AK LOVER ���ڴ� ȸ���鸸�� ���� �����Դϴ�.";
		break;
	case "group_04_09" :  //ü���ı�
		$title_view_all = "ü���ı�";
		break;
	case "group_04_10" : //����ı�
		$title_view_all = "��� �ı⿡ �����ǽ� �������� Ȯ���� �� �ִ� �����Դϴ�.";
		break;
	case "group_04_11" : 
		$title_view_all = "�Ŀ� ��α� ���� �˷������";
		break;
	case "group_04_20" : //�����Ȯ��
		$title_view_all = "��ǰ/���� �߼� ���� �ҽ��� �˷������";
		break;
	case "group_04_21" : //����Ʈ����
		$title_view_all = "�ų� 1ȸ AK LOVER ����Ʈ�� �ְ� ��ǰ�� ��ȯ�� �� �ִ� �����Դϴ�.";
		break;
	case "group_04_22" : //�����ı�
		$title_view_all = "ǰ��ȸ, ��ȭ���� �� ��� �ı⸦ Ȯ���� �� �ִ� �����Դϴ�.";
		break;
	case "group_04_23" :  //�ֽ�Ŭ��
		$title_view_all = "�ְ��� �ְ�/�ֹ���ǰ�� ���� ü���ϰ� �پ��� �ҽ��� ���ϴ� �ֽ�Ŭ�� ȸ�� �����и��� ���� �����Դϴ�.����� ��ϰ� ���� ������, �� ���� ������� ã�� �˰ڽ��ϴ�!";
		break;
	case "mylist" : 
		$title_view_all = "���� �� �Խñ�";
		break;
	case "cus_3" : 
		$title_view_all = "1:1 ���ǻ����� ���� �ּ���";
		break;	
	case "group_04_24" : //�����
		if($_GET["gubun"] == "1") {
			$title_view_all="AK LOVER Ȩ������ Ȱ�� �� ���� �ۼ� �� �ݵ�� �����ؾ� �ϴ� �����Դϴ�.";
		} else if($_GET["gubun"] == "2") {
			$title_view_all="���̹� ��α� �ı� �ۼ� ������ ���� �����Դϴ�.";
		} else if($_GET["gubun"] == "3") {
			$title_view_all="�ν�Ÿ�׷� �ı� �ۼ� ������ ���� �����Դϴ�.";
		} else if($_GET["gubun"] == "4") {
			$title_view_all="��Ʃ�� �Ǵ� ���� �Կ� ���� ������ ���� �����Դϴ�.";
		} else {
			$title_view_all="�ְ� �������� AK LOVER ȸ���е�� ����� �Բ� �ϴ� �����Դϴ�.";
		}
		break;	
	case "group_04_26" : //�ֽ���
		$title_view_all="�ݷ�����(�ݷ���, �ݷ��� ��)�� ���� �Ҽ��� �̾߱�, ������ ������ ������ �����Դϴ�.";
		break;
	case "group_04_27" :  //AK ���� ��Ʃ��
		$title_view_all = "�ְ��� ��Ƽ ��ǰ �Ǵ� ��Ȱ��ǰ�� ���� ü���ϰ� �پ��� �ҽ��� ���ϴ� Beauty/Life Club ������ �����и��� ���� �����Դϴ�."; 
		break;
	case "group_04_28" :  //������ Ŭ��
		$title_view_all = "�ְ� ��Ȱ��ǰ�� ���� ü���ϰ� �پ� �ҽ��� ���ϴ� Life Club ȸ�� �����и��� ���� �����Դϴ�.";
		break;
	case "findpw" :  //���̵�/��й�ȣ ã��
		$title_view_all = "ȸ������ �� �Է��� ������ ���̵�/��й�ȣ�� ã�� �� �ֽ��ϴ�.";
		$titleBigType = "Y";
		break;
	case "without" :  //���̵�/��й�ȣ ã��
		$title_view_all = "ȸ������ �� �Է��� ������ ���̵�/��й�ȣ�� ã�� �� �ֽ��ϴ�.";
		break;
	case "group_04_29" : 
		$title_view_all = "�� �� ���ȸ������ ������ AK LOVER ȸ�����Դ� Ư���� ������ �����ص帳�ϴ�.";
		break;
	case "orderlist" :
		$title_view_all = "�ų� 1ȸ AK LOVER ����Ʈ�� �ְ� ��ǰ�� ��ȯ�� �� �ִ� �����Դϴ�.";
		break;
}

if($_REQUEST["board"] == "agreement") {
	$right_list['hero_title'] = "ȸ������";
} else if($_REQUEST["board"] == "auth") {
	$right_list['hero_title'] = "�������� �� �߰����� �Է�";
}
?>
<div class="introTxtWrap">
	<h1 class="fz44 fw600"><?=$title_view_all?></h1>
</div>
    

